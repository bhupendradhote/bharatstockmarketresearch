@extends('layouts.user')

@section('content')
    <div class="py-24 bg-[#f7f9fc] min-h-screen">
        <div class="max-w-[1400px] mx-auto px-4 md:px-8 lg:px-16">

            <div class="mb-12 mt-2">

                <h2 class="text-3xl md:text-xl font-bold inline-block bg-[#0939a4] text-white px-6 py-2 rounded-full">
                    All Certificates
                </h2>
                <p class="text-gray-600 mt-2">View all issued certificates and research documents.</p>
            </div>

            @if ($certificates->isEmpty())
                <div class="bg-white rounded-[28px] p-12 text-center shadow-sm border border-dashed border-gray-300">
                    <div class="text-6xl mb-4 text-gray-300">📄</div>
                    <h3 class="text-xl font-semibold text-gray-700">No certificates found</h3>
                    <p class="text-gray-500">When certificates are issued to you, they will appear here.</p>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    @foreach ($certificates as $certificate)
                        <div
                            class="bg-white rounded-[28px] p-8 shadow-sm border border-gray-200 hover:border-blue-500 transition-all duration-300">

                            <div class="flex justify-between items-start mb-4">
                                <div
                                    class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-[#0939a4]">
                                    <i class="fa-solid fa-file-contract text-2xl"></i>
                                </div>

                                <div class="text-right">
                                    <span
                                        class="block text-xs font-bold px-3 py-1 bg-green-100 text-green-700 rounded-full uppercase mb-1">
                                        {{ $certificate->certificate_name }}
                                    </span>
                                    <span class="block text-[11px] my-3 px-1 text-gray-500">
                                        Posted on {{ $certificate->created_at->format('d M, Y') }}
                                    </span>
                                </div>
                            </div>


                            {{-- Certificate Viewer (ONLY certificate content, no toolbar) --}}
                            <div class="w-full h-[420px] border border-gray-200 rounded-2xl overflow-hidden bg-gray-50">
                                @php
                                    $fileUrl = Storage::url($certificate->file_path);
                                @endphp

                                @if (Str::endsWith($certificate->file_path, ['jpg', 'jpeg', 'png']))
                                    <img src="{{ $fileUrl }}" alt="Certificate"
                                        class="w-full h-full object-cover bg-white">
                                @else
                                    <iframe src="{{ $fileUrl }}#toolbar=0&navpanes=0&scrollbar=0" class="w-full h-full"
                                        frameborder="0"></iframe>
                                @endif
                            </div>


                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
