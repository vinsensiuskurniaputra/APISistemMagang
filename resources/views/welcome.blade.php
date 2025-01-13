<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sitama</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
</head>
<body class="bg-gray-900 text-gray-100">
    <!-- Navigation Bar -->
    <nav class="fixed top-0 w-full bg-gray-900 bg-opacity-95 backdrop-blur-sm z-50 border-b border-gray-800">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <span class="text-2xl font-bold">📱 Sitama</span>
                </div>
                <div>
                    <a href="{{ route('login') }}" class="bg-red-500 text-white px-6 py-2 rounded-full hover:bg-red-600 transition-all transform hover:scale-105">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-6 pt-24">
        <!-- Hero Section -->
        <header class="text-center my-20 py-20 bg-gradient-to-br from-gray-800 to-gray-900 rounded-3xl shadow-2xl" data-aos="fade-up">
            <h1 class="text-6xl font-bold mb-6">📱 Sitama</h1>
            <p class="text-2xl text-gray-300 mb-8">Simplify Your Internship Experience with Sitama</p>
            <div class="flex justify-center gap-4 flex-wrap">
                <span class="bg-blue-500/20 text-blue-400 px-4 py-2 rounded-full border border-blue-500/30">Flutter</span>
                <span class="bg-green-500/20 text-green-400 px-4 py-2 rounded-full border border-green-500/30">Laravel</span>
                <span class="bg-yellow-500/20 text-yellow-400 px-4 py-2 rounded-full border border-yellow-500/30">MySQL</span>
                <span class="bg-purple-500/20 text-purple-400 px-4 py-2 rounded-full border border-purple-500/30">Figma</span>
            </div>
        </header>

        <!-- Overview Section -->
        <section class="my-20 bg-gray-800/50 p-10 rounded-3xl" data-aos="fade-up">
            <h2 class="text-4xl font-bold mb-6">🌟 Overview</h2>
            <p class="text-xl text-gray-300 leading-relaxed">
                Sitama is a comprehensive mobile application designed to revolutionize the internship mentoring experience for students and faculty at Polytechnic Negeri Semarang. Our platform bridges the gap between students and lecturers, providing a seamless environment for internship guidance, progress tracking, and feedback.
            </p>
        </section>

        <!-- Features Section -->
        <section class="my-20" data-aos="fade-up">
            <h2 class="text-4xl font-bold mb-12">✨ Features</h2>
            <div class="grid md:grid-cols-2 gap-10">
                <!-- Student Features -->
                <div class="bg-gray-800/50 p-8 rounded-3xl">
                    <h3 class="text-2xl font-bold mb-6">👨‍🎓 For Students</h3>
                    <ul class="list-disc list-inside mt-2">
                        <li><strong>Smart Guidance Management</strong>
                            <ul class="list-disc list-inside ml-6">
                                <li>Schedule and track mentoring sessions effortlessly</li>
                                <li>Maintain organized records of all guidance activities</li>
                                <li>Receive real-time updates on session approvals</li>
                            </ul>
                        </li>
                        <li><strong>Digital Logbook</strong>
                            <ul class="list-disc list-inside ml-6">
                                <li>Document daily internship activities with ease</li>
                                <li>Attach supporting materials and evidence</li>
                                <li>Track progress through an intuitive interface</li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- Lecturer Features -->
                <div class="bg-gray-800/50 p-8 rounded-3xl">
                    <h3 class="text-2xl font-bold mb-6">👨‍🏫 For Lecturers</h3>
                    <ul class="list-disc list-inside mt-2">
                        <li><strong>Efficient Approval System</strong>
                            <ul class="list-disc list-inside ml-6">
                                <li>Review and approve guidance sessions</li>
                                <li>Provide structured feedback</li>
                                <li>Track student progress over time</li>
                            </ul>
                        </li>
                        <li><strong>Comprehensive Monitoring</strong>
                            <ul class="list-disc list-inside ml-6">
                                <li>Access detailed student logbooks</li>
                                <li>Monitor internship activities in real-time</li>
                                <li>Generate progress reports</li>
                            </ul>
                        </li>
                        <li><strong>Interactive Feedback</strong>
                            <ul class="list-disc list-inside ml-6">
                                <li>Share detailed session notes</li>
                                <li>Provide targeted guidance</li>
                                <li>Maintain communication records</li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Tech Stack Section -->
        <section class="my-20" data-aos="fade-up">
            <h2 class="text-4xl font-bold mb-12">🚀 Technology Stack</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-gray-800/50 p-8 rounded-3xl">
                    <h3 class="text-2xl font-bold mb-6">Frontend Development</h3>
                    <ul class="list-disc list-inside mt-2">
                        <li>Flutter SDK</li>
                        <li>Dart programming language</li>
                        <li>Material Design components</li>
                    </ul>
                </div>
                <div class="bg-gray-800/50 p-8 rounded-3xl">
                    <h3 class="text-2xl font-bold mb-6">Backend Infrastructure</h3>
                    <ul class="list-disc list-inside mt-2">
                        <li>Laravel 10</li>
                        <li>RESTful API architecture</li>
                        <li>Secure authentication system</li>
                    </ul>
                </div>
                <div class="bg-gray-800/50 p-8 rounded-3xl">
                    <h3 class="text-2xl font-bold mb-6">Database Management</h3>
                    <ul class="list-disc list-inside mt-2">
                        <li>MySQL</li>
                        <li>Efficient data organization</li>
                        <li>Robust backup system</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Team Section -->
        <section class="my-20" data-aos="fade-up">
            <h2 class="text-4xl font-bold mb-12">👥 Meet Our Amazing Team</h2>
            <div class="bg-gray-800/50 rounded-3xl overflow-hidden">
                <table class="table-auto w-full mt-4">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Role</th>
                            <th class="px-4 py-2">Responsibilities</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-4 py-2">Kevin</td>
                            <td class="border px-4 py-2">Project Lead & Frontend Developer</td>
                            <td class="border px-4 py-2">Project management, Flutter development, UI/UX design</td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2">Vinsen</td>
                            <td class="border px-4 py-2">Fullstack Developer</td>
                            <td class="border px-4 py-2">Backend architecture, API development, Frontend integration</td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2">Alip</td>
                            <td class="border px-4 py-2">Design Specialist</td>
                            <td class="border px-4 py-2">Brand identity, Logo design, Visual assets</td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2">Alvina</td>
                            <td class="border px-4 py-2">Frontend Developer</td>
                            <td class="border px-4 py-2">UI implementation, Feature development</td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2">Eka</td>
                            <td class="border px-4 py-2">Frontend Developer</td>
                            <td class="border px-4 py-2">Mobile app development, Testing</td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2">Rahma</td>
                            <td class="border px-4 py-2">Frontend Developer</td>
                            <td class="border px-4 py-2">Feature implementation, UI design</td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2">Seza</td>
                            <td class="border px-4 py-2">Frontend Developer</td>
                            <td class="border px-4 py-2">Component development, UI/UX implementation</td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2">Zaki</td>
                            <td class="border px-4 py-2">Frontend Developer</td>
                            <td class="border px-4 py-2">Mobile development, Interface design</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Contact Section -->
        <section class="my-20 text-center" data-aos="fade-up">
            <h2 class="text-4xl font-bold mb-8">📞 Contact</h2>
            <div class="bg-gray-800/50 p-10 rounded-3xl">
                <p class="text-xl mb-4">For any queries regarding the application, please contact:</p>
                <p class="text-gray-400">Email: -</p>
                <p class="text-gray-400">Website: -</p>
                <p class="mt-8 text-xl">Made with ❤️ by the Sitama Team</p>
            </div>
        </section>
    </div>

    <script>
        AOS.init({
            duration: 1000,
            once: true
        });
    </script>
</body>
</html>
