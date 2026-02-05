@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4" x-data="couponMaster({{ $coupons->toJson() }})">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900">Coupon Management</h1>
            <p class="text-slate-500">Create, edit, and track your promotional discount codes.</p>
        </div>
        <button @click="openForm()"
            class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl font-semibold transition-all shadow-sm">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="Vector"></path><path d="M12 4v16m8-8H4"></path></svg>
            Create Coupon
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <p class="text-sm text-slate-500 font-medium">Total Coupons</p>
            <p class="text-2xl font-bold text-slate-900" x-text="coupons.length"></p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <p class="text-sm text-slate-500 font-medium">Active Now</p>
            <p class="text-2xl font-bold text-green-600" x-text="coupons.filter(c => c.active).length"></p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Coupon Info</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Type & Value</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Usage</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Expiry</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <template x-for="coupon in coupons" :key="coupon.id">
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-mono font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded" x-text="coupon.code"></span>
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                <span x-text="coupon.type === 'flat' ? '₹' : '%'"></span>
                                <span class="font-bold text-slate-900" x-text="coupon.value"></span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-slate-900"><span x-text="coupon.used_global"></span> used</div>
                                <div class="text-xs text-slate-400">Limit: <span x-text="coupon.global_limit"></span></div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600" x-text="coupon.expires_at ?? 'Never'"></td>
                            <td class="px-6 py-4">
                                <button @click="toggleStatus(coupon)"
                                    :class="coupon.active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-500'"
                                    class="px-3 py-1 rounded-full font-bold text-[10px] tracking-widest uppercase transition-colors">
                                    <span x-text="coupon.active ? '● Active' : '○ Inactive'"></span>
                                </button>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button @click="editCoupon(coupon)" class="text-indigo-600 hover:text-indigo-900 font-semibold text-sm px-2">Edit</button>
                                <button @click="confirmDelete(coupon.id)" class="text-red-500 hover:text-red-700 font-semibold text-sm px-2">Delete</button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <div x-show="showForm" 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         style="display: none;">
        
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden" @click.away="closeForm">
            <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-xl font-bold text-slate-800" x-text="editingId ? 'Edit Coupon' : 'Create New Coupon'"></h3>
                <button @click="closeForm" class="text-slate-400 hover:text-slate-600 text-2xl">&times;</button>
            </div>
            
            <div class="p-8 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Coupon Code</label>
                        <input x-model="form.code" class="input uppercase" placeholder="SUMMER2024">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Type</label>
                        <select x-model="form.type" class="input">
                            <option value="flat">Flat Amount (₹)</option>
                            <option value="percent">Percentage (%)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Value</label>
                        <input x-model="form.value" type="number" class="input" placeholder="0.00">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Min. Order Value</label>
                        <input x-model="form.min_amount" type="number" class="input" placeholder="0">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Expiry Date</label>
                        <input x-model="form.expires_at" type="date" class="input">
                    </div>
                </div>
            </div>

            <div class="px-8 py-6 bg-slate-50 flex gap-3 justify-end">
                <button @click="closeForm" class="px-5 py-2 text-slate-600 font-semibold hover:text-slate-800">Cancel</button>
                <button @click="saveCoupon" 
                        class="bg-indigo-600 text-white px-8 py-2 rounded-xl font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all">
                    <span x-text="editingId ? 'Update Coupon' : 'Create Coupon'"></span>
                </button>
            </div>
        </div>
    </div>

    <div x-show="showDeleteModal" 
         class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
         x-transition style="display: none;">
        <div class="bg-white rounded-2xl p-8 max-w-sm w-full text-center shadow-2xl">
            <div class="w-16 h-16 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-2">Are you sure?</h3>
            <p class="text-slate-500 mb-6">This action cannot be undone. This coupon will be permanently removed.</p>
            <div class="flex gap-3">
                <button @click="showDeleteModal = false" class="flex-1 px-4 py-2 bg-slate-100 text-slate-700 rounded-xl font-bold">Cancel</button>
                <button @click="deleteCoupon" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-xl font-bold shadow-lg shadow-red-200">Delete</button>
            </div>
        </div>
    </div>

</div>

<style>
    .input {
        border: 2px solid #f1f5f9;
        padding: .75rem 1rem;
        border-radius: .75rem;
        width: 100%;
        transition: all 0.2s;
        outline: none;
        font-weight: 500;
    }
    .input:focus {
        border-color: #6366f1;
        background-color: #fff;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }
</style>

<script>
function couponMaster(data) {
    return {
        coupons: data,
        showForm: false,
        showDeleteModal: false,
        editingId: null,
        deletingId: null,

        form: {
            code: '',
            type: 'flat',
            value: '',
            min_amount: '',
            per_user_limit: '',
            global_limit: '',
            expires_at: ''
        },

        openForm() {
            this.resetForm();
            this.showForm = true;
        },

        closeForm() {
            this.showForm = false;
        },

        editCoupon(c) {
            this.form = { ...c };
            this.editingId = c.id;
            this.showForm = true;
        },

        confirmDelete(id) {
            this.deletingId = id;
            this.showDeleteModal = true;
        },

        async saveCoupon() {
            let url = this.editingId ? `/admin/coupons/${this.editingId}` : '/admin/coupons';
            let method = this.editingId ? 'PUT' : 'POST';

            try {
                const res = await fetch(url, {
                    method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(this.form)
                });

                const data = await res.json();

                if (this.editingId) {
                    const index = this.coupons.findIndex(c => c.id == this.editingId);
                    this.coupons[index] = data;
                } else {
                    this.coupons.unshift(data);
                }

                this.closeForm();
            } catch (e) {
                alert("Something went wrong!");
            }
        },

        async deleteCoupon() {
            try {
                await fetch(`/admin/coupons/${this.deletingId}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                this.coupons = this.coupons.filter(c => c.id !== this.deletingId);
                this.showDeleteModal = false;
            } catch (e) {
                alert("Error deleting coupon.");
            }
        },

        async toggleStatus(coupon) {
            try {
                await fetch(`/admin/coupons/${coupon.id}/toggle`, {
                    method: 'PATCH',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                coupon.active = !coupon.active;
            } catch (e) {
                alert("Status update failed.");
            }
        },

        resetForm() {
            this.editingId = null;
            this.form = {
                code: '',
                type: 'flat',
                value: '',
                min_amount: '',
                per_user_limit: 1,
                global_limit: 100,
                expires_at: ''
            }
        }
    }
}
</script>
@endsection