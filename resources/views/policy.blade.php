@extends('layouts.user')

@section('content')
    <!-- Tailwind + Icons (Bootstrap Icons CDN used for familiar glyphs) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .policy-section h1,
        .policy-section h2,
        .policy-section h3,
        .policy-section h4,
        .policy-section h5,
        .policy-section h6 {
            color: #1f2937 !important;
            /* slate-800 */
        }
    </style>

    <!-- Page Container -->
    <div class="min-h-screen bg-slate-900 text-slate-50">

        <!-- HERO -->
        <header
            class="relative bg-[url('https://images.pexels.com/photos/730547/pexels-photo-730547.jpeg?auto=compress&cs=tinysrgb&w=1600')] bg-center bg-cover">
            <div class="bg-slate-900/90">
                <div class="max-w-7xl mx-auto px-4 py-20 text-center">
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white">Privacy Policy & Terms of Service
                    </h1>
                    <p class="mt-3 text-sm md:text-base text-slate-300 max-w-2xl mx-auto">
                        Understanding how we protect your data and govern our services
                    </p>

                    <div class="inline-block mt-4">
                        <span
                            class="inline-flex items-center bg-amber-400 text-slate-900 font-semibold text-xs px-3 py-1 rounded-full">
                            Last Updated: January 15, 2025
                        </span>
                    </div>
                </div>
            </div>
        </header>

        <!-- MAIN LAYOUT -->
        <main class="bg-white px-4 py-12">
            <div class="flex flex-col lg:flex-row gap-8">

                <!-- LEFT: SIDEBAR (sticky on lg) -->
                <aside class="lg:w-1/3">
                    <div id="sidebar" class="sticky top-28 bg-[#0f172a] backdrop-blur-sm rounded-xl p-6 hidden lg:block">
                        <h4 class="text-sky-300 font-semibold mb-4">Quick Navigation</h4>

                        <nav class="space-y-1" id="policyNav">
                            <a href="#privacy"
                                class="block text-sm text-slate-200 px-3 py-2 rounded-md border-l-4 border-transparent hover:bg-slate-700 hover:text-sky-300 hover:border-sky-400">Privacy
                                Policy</a>
                            <a href="#information"
                                class="block text-sm text-slate-200 px-3 py-2 rounded-md border-l-4 border-transparent hover:bg-slate-700 hover:text-sky-300 hover:border-sky-400">Information
                                We Collect</a>
                            <a href="#data-use"
                                class="block text-sm text-slate-200 px-3 py-2 rounded-md border-l-4 border-transparent hover:bg-slate-700 hover:text-sky-300 hover:border-sky-400">How
                                We Use Your Data</a>
                            <a href="#data-sharing"
                                class="block text-sm text-slate-200 px-3 py-2 rounded-md border-l-4 border-transparent hover:bg-slate-700 hover:text-sky-300 hover:border-sky-400">Data
                                Sharing</a>
                            <a href="#security"
                                class="block text-sm text-slate-200 px-3 py-2 rounded-md border-l-4 border-transparent hover:bg-slate-700 hover:text-sky-300 hover:border-sky-400">Security
                                Measures</a>
                            <a href="#terms"
                                class="block text-sm text-slate-200 px-3 py-2 rounded-md border-l-4 border-transparent hover:bg-slate-700 hover:text-sky-300 hover:border-sky-400">Terms
                                of Service</a>
                            <a href="#account"
                                class="block text-sm text-slate-200 px-3 py-2 rounded-md border-l-4 border-transparent hover:bg-slate-700 hover:text-sky-300 hover:border-sky-400">Account
                                Terms</a>
                            <a href="#trading"
                                class="block text-sm text-slate-200 px-3 py-2 rounded-md border-l-4 border-transparent hover:bg-slate-700 hover:text-sky-300 hover:border-sky-400">Trading
                                Rules</a>
                            <a href="#liability"
                                class="block text-sm text-slate-200 px-3 py-2 rounded-md border-l-4 border-transparent hover:bg-slate-700 hover:text-sky-300 hover:border-sky-400">Liability</a>
                            <a href="#cookies"
                                class="block text-sm text-slate-200 px-3 py-2 rounded-md border-l-4 border-transparent hover:bg-slate-700 hover:text-sky-300 hover:border-sky-400">Cookie
                                Policy</a>
                            <a href="#gdpr"
                                class="block text-sm text-slate-200 px-3 py-2 rounded-md border-l-4 border-transparent hover:bg-slate-700 hover:text-sky-300 hover:border-sky-400">GDPR
                                Rights</a>
                            <a href="#disclaimer"
                                class="block text-sm text-slate-200 px-3 py-2 rounded-md border-l-4 border-transparent hover:bg-slate-700 hover:text-sky-300 hover:border-sky-400">Risk
                                Disclaimer</a>
                            <a href="#contact"
                                class="block text-sm text-slate-200 px-3 py-2 rounded-md border-l-4 border-transparent hover:bg-slate-700 hover:text-sky-300 hover:border-sky-400">Contact</a>
                        </nav>

                        <div class="mt-6 bg-slate-700/30 p-4 rounded-md">
                            <h5 class="text-sky-300 font-semibold">Need Help?</h5>
                            <p class="text-slate-300 text-sm mt-2">Contact our legal team for policy questions</p>
                            <a href="mailto:bharatstockmarketresearch@gmail.com"
                                class="block mt-3 text-center bg-amber-400 text-slate-900 font-semibold text-sm py-2 rounded-md">Email
                                Legal Team</a>
                        </div>
                    </div>

                    <!-- MOBILE: tabs / accordion -->
                    <div class="lg:hidden">
                        <div class="space-x-2 overflow-auto pb-2 mb-4">
                            <button data-target="#privacy"
                                class="policy-tab inline-block text-xs text-slate-200 bg-slate-800/60 px-3 py-2 rounded-md mr-2">Privacy
                                Policy</button>
                            <button data-target="#terms"
                                class="policy-tab inline-block text-xs text-slate-200 bg-slate-800/60 px-3 py-2 rounded-md mr-2">Terms</button>
                            <button data-target="#cookies"
                                class="policy-tab inline-block text-xs text-slate-200 bg-slate-800/60 px-3 py-2 rounded-md">Cookies</button>
                        </div>
                        <details class="mb-4 bg-slate-800/60 rounded-md p-3">
                            <summary class="text-sm font-semibold text-sky-300">Quick Links</summary>
                            <nav class="mt-2 space-y-1">
                                <a href="#information" class="block text-sm text-slate-200">Information We Collect</a>
                                <a href="#data-use" class="block text-sm text-slate-200">How We Use Your Data</a>
                                <a href="#data-sharing" class="block text-sm text-slate-200">Data Sharing</a>
                                <a href="#security" class="block text-sm text-slate-200">Security Measures</a>
                            </nav>
                        </details>
                    </div>
                </aside>

                <!-- RIGHT: CONTENT -->
                <section class="lg:flex-1">
                    <article class="bg-white text-slate-900 rounded-xl p-6 md:p-8 shadow-lg">

                        <!-- PRINT + ACCEPT CTA -->
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <button id="printBtn"
                                    class="text-sm inline-flex items-center gap-2 px-3 py-1.5 rounded-md border border-slate-200 hover:bg-slate-100">
                                    <i class="bi bi-printer"></i> Print Policy
                                </button>
                                <span class="text-xs text-amber-500 font-semibold">Updated: Jan 15, 2025</span>
                            </div>

                            <div class="text-right">
                                <a href="{{ url('/login') }}"
                                    class="inline-block bg-amber-400 text-slate-900 font-semibold text-sm px-4 py-2 rounded-md hover:bg-amber-300">I
                                    Accept & Continue to Login</a>
                                <p class="text-xs text-slate-500 mt-2">You can always find these policies in our website
                                    footer.</p>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- POLICY SECTIONS -->
                        <section id="privacy" class="policy-section mb-8">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-12 h-12 rounded-full bg-sky-100 flex items-center justify-center text-sky-600">
                                    <i class="bi bi-shield-check"></i>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold mb-2">Privacy Policy</h2>
                                    <p class="text-sm text-slate-600">At Bharat Stock Trade, we are committed to protecting
                                        your
                                        privacy and ensuring the security of your personal and financial information. This
                                        Privacy Policy explains how we collect, use, disclose, and safeguard your
                                        information when you use our trading platform and services.</p>
                                    <p class="text-sm text-slate-600 mt-3">By using Bharat Stock Trade, you consent to the
                                        data
                                        practices described in this policy. If you do not agree with our policies and
                                        practices, please do not use our services.</p>
                                </div>
                            </div>
                        </section>

                        <section id="information" class="policy-section mb-8">
                            <h3 class="text-lg font-semibold mb-3">1. Information We Collect</h3>

                            <h4 class="font-semibold mt-3 mb-1">1.1 Personal Information</h4>
                            <p class="text-sm text-slate-600">When you create an account or use our services, we collect:
                            </p>
                            <ul class="list-disc pl-5 text-sm text-slate-600 space-y-1 my-2">
                                <li>Full name, date of birth, and contact information</li>
                                <li>Government-issued identification (PAN, Aadhaar, passport)</li>
                                <li>Financial information (bank account details, income proof)</li>
                                <li>Contact details (email, phone number, address)</li>
                                <li>KYC documents as required by regulatory authorities</li>
                            </ul>

                            <h4 class="font-semibold mt-3 mb-1">1.2 Trading Information</h4>
                            <p class="text-sm text-slate-600">We collect data related to your trading activities:</p>
                            <ul class="list-disc pl-5 text-sm text-slate-600 space-y-1 my-2">
                                <li>Trade orders, executions, and portfolio holdings</li>
                                <li>Market data and analytics you access</li>
                                <li>Device information and IP addresses</li>
                                <li>Log files and usage patterns</li>
                            </ul>

                            <div class="mt-4 p-4 bg-sky-50 border-l-4 border-sky-300 rounded-md">
                                <h5 class="font-semibold text-slate-800">Note on Sensitive Data</h5>
                                <p class="text-sm text-slate-600 mt-1">We implement additional security measures for
                                    sensitive financial data. Your trading passwords and authentication tokens are encrypted
                                    and never stored in plain text.</p>
                            </div>
                        </section>

                        <section id="data-use" class="policy-section mb-8">
                            <h3 class="text-lg font-semibold mb-3">2. How We Use Your Information</h3>
                            <p class="text-sm text-slate-600 mb-3">We use the collected information for the following
                                purposes:</p>

                            <div class="overflow-x-auto">
                                <table class="min-w-full text-left text-sm">
                                    <thead>
                                        <tr class="bg-sky-600 text-white">
                                            <th class="px-4 py-3">Purpose</th>
                                            <th class="px-4 py-3">Description</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white">
                                        <tr class="border-b">
                                            <td class="px-4 py-3 font-semibold">Account Management</td>
                                            <td class="px-4 py-3 text-slate-600">Create and maintain your trading account,
                                                verify identity, and process transactions</td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="px-4 py-3 font-semibold">Regulatory Compliance</td>
                                            <td class="px-4 py-3 text-slate-600">Fulfill legal obligations under SEBI, RBI,
                                                and other regulatory authorities</td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="px-4 py-3 font-semibold">Service Improvement</td>
                                            <td class="px-4 py-3 text-slate-600">Enhance platform features, fix bugs, and
                                                develop new functionalities</td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="px-4 py-3 font-semibold">Security & Fraud Prevention</td>
                                            <td class="px-4 py-3 text-slate-600">Detect and prevent fraudulent activities
                                                and security breaches</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 font-semibold">Communication</td>
                                            <td class="px-4 py-3 text-slate-600">Send important updates, market alerts, and
                                                service notifications</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </section>

                        <section id="data-sharing" class="policy-section mb-8">
                            <h3 class="text-lg font-semibold mb-3">3. Data Sharing and Disclosure</h3>
                            <p class="text-sm text-slate-600">We may share your information in the following circumstances:
                            </p>

                            <h4 class="font-semibold mt-3">3.1 With Regulatory Authorities</h4>
                            <p class="text-sm text-slate-600">As required by law, we share information with SEBI, stock
                                exchanges, and other regulatory bodies for compliance and audit purposes.</p>

                            <h4 class="font-semibold mt-3">3.2 With Service Providers</h4>
                            <p class="text-sm text-slate-600">We work with trusted third-party providers for:</p>
                            <ul class="list-disc pl-5 text-sm text-slate-600 space-y-1 my-2">
                                <li>Payment processing and banking services</li>
                                <li>Cloud hosting and infrastructure</li>
                                <li>KYC verification services</li>
                                <li>Customer support and communication</li>
                            </ul>

                            <h4 class="font-semibold mt-3">3.3 Business Transfers</h4>
                            <p class="text-sm text-slate-600">In the event of a merger, acquisition, or sale of assets,
                                your information may be transferred as part of the transaction.</p>

                            <div class="mt-4 p-4 bg-amber-50 border-l-4 border-amber-300 rounded-md">
                                <h5 class="font-semibold text-amber-700">Important Notice</h5>
                                <p class="text-sm text-amber-700 mt-1">We <strong>do not sell</strong> your personal data
                                    to third parties for marketing purposes. All data sharing is governed by strict
                                    confidentiality agreements.</p>
                            </div>
                        </section>

                        <section id="security" class="policy-section mb-8">
                            <h3 class="text-lg font-semibold mb-3">4. Security Measures</h3>
                            <p class="text-sm text-slate-600">We implement industry-standard security measures to protect
                                your data:</p>
                            <ul class="list-disc pl-5 text-sm text-slate-600 space-y-1 my-2">
                                <li><strong>256-bit SSL Encryption:</strong> All data transmitted between your device and
                                    our servers is encrypted</li>
                                <li><strong>Two-Factor Authentication:</strong> Optional 2FA for enhanced account security
                                </li>
                                <li><strong>Regular Security Audits:</strong> Periodic penetration testing and vulnerability
                                    assessments</li>
                                <li><strong>Data Anonymization:</strong> Trading data used for analytics is anonymized</li>
                                <li><strong>Access Controls:</strong> Strict role-based access for employees</li>
                            </ul>
                        </section>

                        <section id="terms" class="policy-section mb-8">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-700">
                                    <i class="bi bi-file-text"></i>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold mb-2">Terms of Service</h2>
                                    <p class="text-sm text-slate-600">These Terms of Service govern your use of the Bharat
                                        Stock Trade
                                        trading platform. By accessing or using our services, you agree to be bound by these
                                        terms.</p>
                                </div>
                            </div>
                        </section>

                        <section id="account" class="policy-section mb-8">
                            <h3 class="text-lg font-semibold mb-3">1. Account Terms</h3>

                            <h4 class="font-semibold mt-3 mb-1">1.1 Eligibility</h4>
                            <p class="text-sm text-slate-600">To use Bharat Stock Trade, you must:</p>
                            <ul class="list-disc pl-5 text-sm text-slate-600 space-y-1 my-2">
                                <li>Be at least 18 years old</li>
                                <li>Have legal capacity to enter into contracts</li>
                                <li>Complete the KYC verification process</li>
                                <li>Reside in a jurisdiction where our services are available</li>
                            </ul>

                            <h4 class="font-semibold mt-3 mb-1">1.2 Account Security</h4>
                            <p class="text-sm text-slate-600">You are responsible for:</p>
                            <ul class="list-disc pl-5 text-sm text-slate-600 space-y-1 my-2">
                                <li>Maintaining the confidentiality of your login credentials</li>
                                <li>All activities that occur under your account</li>
                                <li>Immediately notifying us of any unauthorized access</li>
                                <li>Ensuring your contact information is up to date</li>
                            </ul>
                        </section>

                        <section id="trading" class="policy-section mb-8">
                            <h3 class="text-lg font-semibold mb-3">2. Trading Rules and Responsibilities</h3>
                            <p class="text-sm text-slate-600 mb-3">As a user of Bharat Stock Trade, you agree to:</p>
                            <ul class="list-disc pl-5 text-sm text-slate-600 space-y-1 my-2">
                                <li>Comply with all applicable laws and regulations</li>
                                <li>Not engage in market manipulation or fraudulent activities</li>
                                <li>Understand that all trading involves risk of loss</li>
                                <li>Make independent investment decisions based on your research</li>
                                <li>Not hold Bharat Stockliable for trading losses</li>
                            </ul>

                            <h4 class="font-semibold mt-3 mb-1">2.1 Order Execution</h4>
                            <p class="text-sm text-slate-600">While we strive for best execution, market conditions may
                                affect order execution. We are not responsible for delays or failures in order execution due
                                to:</p>
                            <ul class="list-disc pl-5 text-sm text-slate-600 space-y-1 my-2">
                                <li>Market volatility or liquidity issues</li>
                                <li>Technical issues with exchange systems</li>
                                <li>Internet connectivity problems</li>
                                <li>Force majeure events</li>
                            </ul>
                        </section>

                        <section id="liability" class="policy-section mb-8">
                            <h3 class="text-lg font-semibold mb-3">3. Limitation of Liability</h3>
                            <p class="text-sm text-slate-600">To the maximum extent permitted by law:</p>
                            <ul class="list-disc pl-5 text-sm text-slate-600 space-y-1 my-2">
                                <li>Bharat Stockis not liable for indirect, incidental, or consequential damages</li>
                                <li>Our total liability shall not exceed the fees you paid in the last 6 months</li>
                                <li>We are not responsible for third-party services or content</li>
                                <li>Market data is provided "as is" without warranties</li>
                            </ul>
                        </section>

                        <section id="cookies" class="policy-section mb-8">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center text-amber-700">
                                    <i class="bi bi-cookie"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold mb-2">Cookie Policy</h3>
                                    <p class="text-sm text-slate-600">We use cookies and similar technologies to enhance
                                        your experience:</p>

                                    <div class="overflow-x-auto mt-3">
                                        <table class="min-w-full text-sm">
                                            <thead>
                                                <tr class="bg-sky-600 text-white">
                                                    <th class="px-4 py-3 text-left">Cookie Type</th>
                                                    <th class="px-4 py-3 text-left">Purpose</th>
                                                    <th class="px-4 py-3 text-left">Duration</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white">
                                                <tr class="border-b">
                                                    <td class="px-4 py-3 font-semibold">Essential Cookies</td>
                                                    <td class="px-4 py-3 text-slate-600">Enable core functionality and
                                                        security</td>
                                                    <td class="px-4 py-3 text-slate-600">Session</td>
                                                </tr>
                                                <tr class="border-b">
                                                    <td class="px-4 py-3 font-semibold">Performance Cookies</td>
                                                    <td class="px-4 py-3 text-slate-600">Analyze usage and improve
                                                        performance</td>
                                                    <td class="px-4 py-3 text-slate-600">1 year</td>
                                                </tr>
                                                <tr class="border-b">
                                                    <td class="px-4 py-3 font-semibold">Functional Cookies</td>
                                                    <td class="px-4 py-3 text-slate-600">Remember preferences and settings
                                                    </td>
                                                    <td class="px-4 py-3 text-slate-600">1 month</td>
                                                </tr>
                                                <tr>
                                                    <td class="px-4 py-3 font-semibold">Advertising Cookies</td>
                                                    <td class="px-4 py-3 text-slate-600">Deliver relevant advertisements
                                                    </td>
                                                    <td class="px-4 py-3 text-slate-600">3 months</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section id="gdpr" class="policy-section mb-8">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-12 h-12 rounded-full bg-sky-100 flex items-center justify-center text-sky-600">
                                    <i class="bi bi-globe-europe-africa"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold mb-2">GDPR Compliance</h3>
                                    <p class="text-sm text-slate-600">For users in the European Union, we comply with the
                                        General Data Protection Regulation (GDPR). You have the right to:</p>
                                    <ul class="list-disc pl-5 text-sm text-slate-600 mt-2 space-y-1">
                                        <li><strong>Access:</strong> Request copies of your personal data</li>
                                        <li><strong>Rectification:</strong> Request correction of inaccurate data</li>
                                        <li><strong>Erasure:</strong> Request deletion of your data</li>
                                        <li><strong>Restriction:</strong> Request limitation of processing</li>
                                        <li><strong>Portability:</strong> Request transfer of your data</li>
                                        <li><strong>Objection:</strong> Object to data processing</li>
                                    </ul>
                                    <p class="text-sm text-slate-600 mt-3">To exercise these rights, contact our Data
                                        Protection Officer at <strong>bharatstockmarketresearch@gmail.com</strong>.</p>
                                </div>
                            </div>
                        </section>

                        <section id="disclaimer" class="policy-section mb-8">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center text-amber-700">
                                    <i class="bi bi-exclamation-triangle"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold mb-2">Risk Disclaimer</h3>
                                    <div class="p-4 bg-amber-50 border-l-4 border-amber-300 rounded-md">
                                        <h5 class="font-semibold text-amber-700">Important Risk Warning</h5>
                                        <p class="text-sm text-amber-700 mt-1"><strong>Trading in securities, derivatives,
                                                and other financial instruments involves substantial risk of loss.</strong>
                                            Past performance is not indicative of future results. You should carefully
                                            consider whether trading is appropriate for you in light of your experience,
                                            objectives, financial resources, and other circumstances.</p>
                                    </div>
                                    <p class="text-sm text-slate-600 mt-3">Bharat Stockprovides execution services and does
                                        not
                                        offer investment advice. All trading decisions are your own responsibility.</p>
                                </div>
                            </div>
                        </section>

                        <section id="contact" class="policy-section mb-8">
                            <h3 class="text-lg font-semibold mb-3">Contact Information</h3>
                            <p class="text-sm text-slate-600">For questions about these policies, contact us:</p>
                            <ul class="list-disc pl-5 text-sm text-slate-600 mt-2 space-y-1">
                                <li><strong>Legal Department:</strong> bharatstockmarketresearch@gmail.com</li>
                                <li><strong>Data Protection Officer:</strong> bharatstockmarketresearch@gmail.com</li>
                                <li><strong>Registered Office:</strong> 223, Qila Chawni,Near Holi Chowk Ward No. 47, Rampur
                                    Road, Bareilly, India</li>
                                <li><strong>Phone:</strong> +91 94 5729 6893</li>
                            </ul>

                            <p class="text-sm text-slate-600 mt-4"><strong>Changes to Policies:</strong> We may update
                                these policies periodically. Continued use of our services after changes constitutes
                                acceptance of the revised policies.</p>
                        </section>

                    </article>
                </section>

            </div>
        </main>
    </div>

    <!-- JS: smooth scroll, sidebar active state, tabs & print -->
    <script>
        (function() {
            // Smooth scrolling for internal links (sidebar + tabs)
            function scrollToEl(target) {
                const el = document.querySelector(target);
                if (!el) return;
                const offset = 120; // header offset
                const top = el.getBoundingClientRect().top + window.scrollY - offset;
                window.scrollTo({
                    top,
                    behavior: 'smooth'
                });
            }

            // Sidebar links
            document.querySelectorAll('a[href^="#"]').forEach(a => {
                a.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    if (!href.startsWith('#')) return;
                    e.preventDefault();
                    // Remove active classes in sidebar
                    document.querySelectorAll('#policyNav a').forEach(x => x.classList.remove(
                        'bg-slate-700', 'text-sky-300', 'border-sky-400'));
                    // If the clicked link is inside the sidebar, set active
                    if (this.closest('#policyNav')) {
                        this.classList.add('bg-slate-700', 'text-sky-300', 'border-sky-400');
                    }
                    scrollToEl(href);
                });
            });

            // Mobile tab buttons
            document.querySelectorAll('.policy-tab').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('.policy-tab').forEach(b => b.classList.remove(
                        'bg-slate-700'));
                    this.classList.add('bg-slate-700');
                    const target = this.getAttribute('data-target') || this.dataset.target;
                    if (target) scrollToEl(target);
                });
            });

            // Update active sidebar link on scroll
            const sections = Array.from(document.querySelectorAll('.policy-section'));
            const navLinks = Array.from(document.querySelectorAll('#policyNav a'));

            function onScroll() {
                const scrollPos = window.scrollY + 160;
                let currentId = null;
                sections.forEach(s => {
                    if (s.offsetTop <= scrollPos) currentId = '#' + s.id;
                });
                navLinks.forEach(link => {
                    link.classList.remove('bg-slate-700', 'text-sky-300', 'border-sky-400');
                    if (link.getAttribute('href') === currentId) {
                        link.classList.add('bg-slate-700', 'text-sky-300', 'border-sky-400');
                    }
                });
            }

            window.addEventListener('scroll', onScroll);
            onScroll();

            // Print
            const printBtn = document.getElementById('printBtn');
            if (printBtn) printBtn.addEventListener('click', () => window.print());

        })();
    </script>
@endsection
