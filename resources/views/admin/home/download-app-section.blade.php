@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="grid grid-cols-12 gap-8 text-sm">

        <aside class="col-span-12 lg:col-span-3 space-y-4">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-700 uppercase tracking-wider text-[11px]">Pages</h3>
                </div>

                <div class="p-2 space-y-1">
                    @foreach ($pages as $key => $label)
                        <a href="{{ route('admin.home.download-app.index', ['page' => $key]) }}"
                            class="group flex items-center justify-between px-4 py-3 rounded-lg transition-all duration-200
                            {{ $pageKey === $key 
                                ? 'bg-blue-600 text-white shadow-md shadow-blue-100' 
                                : 'text-slate-600 hover:bg-slate-50 hover:text-blue-600' }}">
                            
                            <span class="font-medium">{{ $label }}</span>

                            <div class="flex items-center">
                                @if (isset($sections[$key]))
                                    <div class="flex items-center">
                                        <span class="relative flex h-3 w-3 mr-2">
                                            @if($sections[$key]->is_active)
                                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                                <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                                            @else
                                                <span class="relative inline-flex rounded-full h-3 w-3 bg-slate-300"></span>
                                            @endif
                                        </span>
                                        <span class="text-[10px] uppercase font-bold {{ $pageKey === $key ? 'text-blue-100' : 'text-slate-400' }}">
                                            {{ $sections[$key]->is_active ? 'Active' : 'Off' }}
                                        </span>
                                    </div>
                                @else
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-700 uppercase">New</span>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </aside>

        <main class="col-span-12 lg:col-span-9 bg-white rounded-xl shadow-sm border border-slate-200" 
              x-data="{ editMode: {{ $section ? 'false' : 'true' }} }">

            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-white rounded-t-xl">
                <div>
                    <nav class="text-xs text-slate-400 mb-1">Admin / Home / Download Section</nav>
                    <h2 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                        {{ ucfirst($pageKey) }}
                        @if($section && !$section->is_active)
                            <span class="bg-red-50 text-red-500 text-[10px] px-2 py-0.5 rounded-full uppercase tracking-tighter border border-red-100">Hidden</span>
                        @endif
                    </h2>
                </div>

                @if ($section)
                    <button @click="editMode = !editMode" 
                        class="inline-flex items-center px-4 py-2 rounded-lg font-semibold text-xs transition-all
                        :class="editMode ? 'bg-slate-100 text-slate-600 hover:bg-slate-200' : 'bg-blue-600 text-white hover:bg-blue-700 shadow-sm'">
                        <template x-if="!editMode">
                            <span class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                Edit Section
                            </span>
                        </template>
                        <template x-if="editMode">
                            <span>Cancel</span>
                        </template>
                    </button>
                @endif
            </div>

            <div class="p-6">
                @if ($errors->any())
                    <div class="mb-6 flex items-start gap-3 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
                        <div class="text-red-500 mt-0.5">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        </div>
                        <ul class="text-xs text-red-700 font-medium">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-6 flex items-center gap-3 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg text-emerald-700 font-medium text-xs">
                        <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        {{ session('success') }}
                    </div>
                @endif

                <div x-show="!editMode" x-transition.opacity class="grid lg:grid-cols-5 gap-10">
                    <div class="lg:col-span-3 space-y-6">
                        <div>
                            <span class="text-blue-600 font-bold uppercase tracking-widest text-[10px]">Title Tag</span>
                            <h4 class="text-xl font-semibold text-slate-800 mt-1">{{ $section?->title ?? 'Untitled' }}</h4>
                        </div>

                        <div>
                            <span class="text-slate-400 font-bold uppercase tracking-widest text-[10px]">Main Heading</span>
                            <p class="text-lg text-slate-700 leading-relaxed">{{ $section?->heading ?? '—' }}</p>
                        </div>

                        <div>
                            <span class="text-slate-400 font-bold uppercase tracking-widest text-[10px]">Description</span>
                            <p class="text-slate-500 leading-relaxed">{{ $section?->description ?? 'No description provided.' }}</p>
                        </div>
                    </div>

                    <div class="lg:col-span-2">
                        <span class="text-slate-400 font-bold uppercase tracking-widest text-[10px] mb-2 block">Visual Preview</span>
                        @if ($section?->getFirstMediaUrl('image'))
                            <div class="relative group">
                                <img src="{{ $section->getFirstMediaUrl('image') }}"
                                    class="w-full aspect-video object-cover rounded-xl border border-slate-200 shadow-sm">
                            </div>
                        @else
                            <div class="aspect-video bg-slate-50 border-2 border-dashed border-slate-200 rounded-xl flex flex-col items-center justify-center text-slate-400">
                                <svg class="w-8 h-8 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                <span class="text-xs">No media uploaded</span>
                            </div>
                        @endif
                    </div>
                </div>

                <form x-show="editMode" x-transition method="POST" action="{{ route('admin.home.download-app.store') }}"
                    enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    
                    <div class="grid lg:grid-cols-2 gap-8">
                        <div class="space-y-5">
                            <div>
                                <label class="block text-slate-700 font-semibold mb-1.5">Selected Page</label>
                                <select name="page_key" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all">
                                    @foreach ($pages as $key => $label)
                                        <option value="{{ $key }}" {{ $pageKey === $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-slate-700 font-semibold mb-1.5">Title</label>
                                <input type="text" name="title" value="{{ old('title', $section?->title) }}"
                                    placeholder="e.g. Download our app"
                                    class="w-full border border-slate-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all">
                            </div>

                            <div>
                                <label class="block text-slate-700 font-semibold mb-1.5">Heading</label>
                                <input type="text" name="heading" value="{{ old('heading', $section?->heading) }}"
                                    placeholder="e.g. Experience the best service"
                                    class="w-full border border-slate-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all">
                            </div>

                            <div>
                                <label class="block text-slate-700 font-semibold mb-1.5">Description</label>
                                <textarea name="description" rows="4"
                                    placeholder="Enter short description..."
                                    class="w-full border border-slate-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all">{{ old('description', $section?->description) }}</textarea>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-slate-700 font-semibold mb-2">Section Image</label>
                                <div class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-xl p-4">
                                    @if ($section?->getFirstMediaUrl('image'))
                                        <img src="{{ $section->getFirstMediaUrl('image') }}" class="h-32 w-full object-cover mb-4 rounded-lg shadow-sm border border-white">
                                    @endif
                                    
                                    <input type="file" name="image" class="block w-full text-xs text-slate-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-xs file:font-semibold
                                        file:bg-blue-50 file:text-blue-700
                                        hover:file:bg-blue-100 transition-all cursor-pointer">
                                </div>
                            </div>

                            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ $section?->is_active ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    <span class="ml-3 text-sm font-semibold text-slate-700">Display this section on website</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-slate-100">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-8 py-3 rounded-xl shadow-lg shadow-blue-200 transition-all active:scale-95">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
@endsection