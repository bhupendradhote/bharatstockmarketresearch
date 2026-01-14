@extends('layouts.userdashboard')

@section('content')
    <div class=" bg-[#f8fafc]" x-data="{ newsTab: 'More News' }">

        <div
            class="grid grid-cols-1 lg:grid-cols-12 gap-8 bg-white rounded-[32px] border border-gray-100 shadow-sm p-6 md:p-10">

            <div class="lg:col-span-4 flex flex-col">
                <h2 class="text-2xl font-extrabold text-[#0939a4] leading-tight mb-4">
                    Amazon, Flipkart festive blitz fuels 29% YoY surge in first-week sales to record Rs 60,700 crore
                </h2>
                <p class="text-xs text-gray-500 font-medium mb-6 leading-relaxed">
                    GST reforms, early access deals and a surge in Gen Z spending have turbocharged demand across
                    categories, from smartphones to appliances.
                </p>

                <div class="rounded-3xl overflow-hidden mb-8 shadow-lg">
                    <img src="https://images.unsplash.com/photo-1523474253046-2cd2c78a9db1?auto=format&fit=crop&q=80&w=800"
                        alt="Amazon Warehouse" class="w-full h-64 object-cover">
                </div>

                <div class="flex border-b border-gray-100 mb-6 gap-6">
                    <button @click="newsTab = 'More News'"
                        :class="newsTab === 'More News' ? 'border-b-2 border-[#0939a4] text-[#0939a4]' : 'text-[#0939a4]'"
                        class="pb-2 text-[11px] font-bold uppercase tracking-wider transition-all">More News</button>
                    <button @click="newsTab = 'Recent News'"
                        :class="newsTab === 'Recent News' ? 'border-b-2 border-[#0939a4] text-[#0939a4]' : 'text-[#0939a4]'"
                        class="pb-2 text-[11px] font-bold uppercase tracking-wider transition-all">Recent News</button>
                </div>

                <div class="space-y-6">
                    <template x-for="item in [1, 2, 3, 4]">
                        <div class="border-b border-gray-50 pb-4 last:border-0">
                            <p
                                class="text-xs font-bold text-gray-800 leading-snug hover:text-blue-600 cursor-pointer transition-colors">
                                'Must stop treating Kerala...': Tharoor flags concerns over Air India Express plans to
                                curtail flights
                            </p>
                        </div>
                    </template>
                </div>
            </div>

            <div class="lg:col-span-4 border-x border-gray-50 px-0 lg:px-8">
                <div class="mb-10">
                    <h3 class="text-xl font-extrabold text-[#0939a4] border-b-2 border-[#0939a4] inline-block mb-4">Market
                        Insight</h3>
                    <p class="text-sm font-bold text-gray-800 mb-4 italic">Indian markets set for flat start on global cues
                    </p>
                    <ul class="space-y-3 list-disc list-inside text-[11px] font-bold text-gray-600">
                        <li class="hover:text-blue-600 cursor-pointer">Stock Market LIVE Updates: Nifty opens near 24,700,
                            Sensex up 250 pts; BEL, M&M, IRFC in focus</li>
                        <li class="hover:text-blue-600 cursor-pointer">Japan-based UNLEASH Capital closes Rs 300 crore
                            fintech fund for India</li>
                        <li class="hover:text-blue-600 cursor-pointer">Is India's private sector faking its animal spirits?
                        </li>
                    </ul>
                </div>

                <div class="mb-10">
                    <h3 class="text-xl font-extrabold text-[#0939a4] border-b-2 border-[#0939a4] inline-block mb-4">In the
                        News</h3>
                    <p class="text-sm font-bold text-gray-800 mb-4">PM Modi welcomes US President Trump's Gaza peace plan:
                        'Viable pathway to long-term peace'</p>
                    <ul class="space-y-3 list-disc list-inside text-[11px] font-bold text-gray-600">
                        <li class="hover:text-blue-600 cursor-pointer">Stock Market LIVE Updates: Nifty opens near 24,700,
                            Sensex up 250 pts</li>
                        <li class="hover:text-blue-600 cursor-pointer">Japan-based UNLEASH Capital closes Rs 300 crore
                            fintech fund</li>
                        <li class="hover:text-blue-600 cursor-pointer">Is India's private sector faking its animal spirits?
                        </li>
                    </ul>
                </div>

                <div class="space-y-6 pt-4 border-t border-gray-50">
                    <div>
                        <h4
                            class="text-xs font-black uppercase tracking-widest text-gray-400 border-b border-gray-100 pb-1 mb-2">
                            Chat of the Day</h4>
                        <p class="text-[11px] font-bold text-gray-700">Hindustan Aeronautics, Bharat Electronics holding on
                            to their ground despite a rise in competition</p>
                    </div>
                    <div>
                        <h4
                            class="text-xs font-black uppercase tracking-widest text-gray-400 border-b border-gray-100 pb-1 mb-2">
                            Women's ODI World Cup</h4>
                        <p class="text-[11px] font-bold text-gray-700">Breaking New Ground: Women's Cricket's $13.88 million
                            leap forward</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-4">
                <h3 class="text-xl font-extrabold text-[#0939a4] border-b-2 border-[#0939a4] inline-block mb-6">Trending News
                </h3>

                <div class="space-y-8">
                    <template x-for="i in [1, 2, 3, 4, 5, 6, 7]">
                        <div class="group cursor-pointer">
                            <p
                                class="text-xs font-bold text-gray-800 leading-snug group-hover:text-blue-600 transition-colors">
                                'Must stop treating Kerala...': Tharoor flags concerns over Air India Express plans to
                                curtail flights
                            </p>
                            <div class="h-[1px] bg-gray-100 w-full mt-4"></div>
                        </div>
                    </template>

                    <div class="group cursor-pointer">
                        <p class="text-xs font-bold text-gray-800 leading-snug group-hover:text-blue-600 transition-colors">
                            Indian High Commission condemns vandalism of Gandhi statue in London ahead of International Day
                            of Non-Violence
                        </p>
                        <div class="h-[1px] bg-gray-100 w-full mt-4"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
