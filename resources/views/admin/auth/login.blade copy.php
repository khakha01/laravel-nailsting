<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | NailSting</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }

        .glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .input-focus {
            transition: all 0.3s ease;
        }

        .input-focus:focus {
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.5);
            border-color: #6366f1;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.8s ease-out forwards;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md animate-fadeIn">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-white mb-2">NailSting</h1>
            <p class="text-gray-400">Hệ thống quản lý Admin chuyên nghiệp</p>
        </div>

        <div class="glass p-8 rounded-2xl shadow-2xl">
            <h2 class="text-2xl font-semibold text-white mb-6 text-center">
                Đăng nhập hệ thống
            </h2>

            <form id="loginForm" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Email
                    </label>
                    <input type="email" id="email" required
                        class="w-full px-4 py-3 bg-gray-900/50 border border-gray-700 rounded-xl text-white placeholder-gray-500 input-focus outline-none"
                        placeholder="admin@example.com">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Mật khẩu
                    </label>
                    <input type="password" id="password" required
                        class="w-full px-4 py-3 bg-gray-900/50 border border-gray-700 rounded-xl text-white placeholder-gray-500 input-focus outline-none"
                        placeholder="••••••••">
                </div>

                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center text-gray-400 cursor-pointer">
                        <input type="checkbox" id="remember"
                            class="mr-2 rounded border-gray-700 bg-gray-900 text-indigo-600 focus:ring-indigo-500">
                        Ghi nhớ đăng nhập
                    </label>

                    <a href="#" class="text-indigo-400 hover:text-indigo-300 transition-colors">
                        Quên mật khẩu?
                    </a>
                </div>

                <button type="submit" id="submitBtn"
                    class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-all transform hover:scale-[1.02] active:scale-[0.98] shadow-lg shadow-indigo-600/20">
                    Đăng Nhập
                </button>
            </form>

            <div id="errorMessage"
                class="mt-4 p-3 rounded-lg bg-red-500/10 border border-red-500/50 text-red-400 text-sm hidden text-center">
            </div>
        </div>

        <p class="mt-8 text-center text-gray-500 text-sm">
            &copy; 2026 NailSting. Built with &hearts; for beauty professionals.
        </p>
    </div>
    <script>
        const loginForm = document.getElementById('loginForm');
        const errorMessage = document.getElementById('errorMessage');
        const submitBtn = document.getElementById('submitBtn');

        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            errorMessage.classList.add('hidden');
            submitBtn.disabled = true;
            submitBtn.innerHTML =
                '<span class="inline-block animate-spin mr-2">&#8635;</span> Đang xử lý...';

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const remember = document.getElementById('remember').checked;

            try {
                const response = await fetch('/api/admin/auth/login', {
                    method: 'POST',
                    credentials: 'include', // ✅ QUAN TRỌNG
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        email,
                        password,
                        remember
                    })
                });

                let result = {};
                try {
                    result = await response.json();
                } catch { }

                if (response.ok) {
                    window.location.href = '/admin/dashboard';
                } else {
                    errorMessage.textContent =
                        result.message ||
                        (result.errors
                            ? Object.values(result.errors)[0][0]
                            : 'Đăng nhập thất bại.');
                    errorMessage.classList.remove('hidden');
                }
            } catch (err) {
                errorMessage.textContent = 'Đã có lỗi xảy ra. Vui lòng thử lại sau.';
                errorMessage.classList.remove('hidden');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerText = 'Đăng Nhập';
            }
        });
    </script>
</body>

</html>