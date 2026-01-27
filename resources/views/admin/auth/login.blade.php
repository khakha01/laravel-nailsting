<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NAILSTING Admin • Đăng nhập</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
            overflow: hidden;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow:
                0 10px 30px -10px rgba(0, 0, 0, 0.08),
                0 4px 12px -2px rgba(0, 0, 0, 0.05);
        }

        .input-field {
            background: white;
            border: 1.5px solid #e2e8f0;
            transition: all 0.25s ease;
        }

        .input-field:focus {
            border-color: #1777d5;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.12);
            outline: none;
        }

        .btn-modern {
            background: #1777d5;
            transition: all 0.3s ease;
        }

        .btn-modern:hover {
            background: #1777d5;
            transform: translateY(-1.5px);
            box-shadow: 0 12px 24px -8px rgba(99, 102, 241, 0.35);
        }

        .btn-modern:active {
            transform: translateY(0);
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

        .animate-fade {
            animation: fadeIn 0.8s ease-out forwards;
        }
    </style>
</head>

<body class="flex items-center justify-center p-6">

    <div class="w-full max-w-sm">
        <div class="text-center mb-10 animate-fade">
            <h1 class="text-3xl font-bold text-gray-800 tracking-tight">CMS Admin</h1>
            <p class="mt-1.5 text-sm text-gray-500 font-medium">
                Content Management System
            </p>
        </div>
        <div class="glass-card rounded-3xl p-10 animate-fade" style="animation-delay: 0.15s;">
            <form id="loginForm" class="space-y-6">
                <!-- Email -->
                <div class="space-y-2">
                    <label class="text-xs font-semibold text-gray-600 uppercase tracking-wide ml-1">Email quản
                        trị</label>
                    <input type="email" id="email" required
                        class="input-field w-full px-5 py-4 rounded-2xl text-gray-800 placeholder-gray-400 text-sm focus:outline-none"
                        placeholder="admin@gmail.vn" />
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <label class="text-xs font-semibold text-gray-600 uppercase tracking-wide ml-1">Mật khẩu</label>
                        <a href="#"
                            class="text-xs text-indigo-600 hover:text-indigo-700 font-medium transition-colors">Quên mật
                            khẩu?</a>
                    </div>
                    <input type="password" id="password" required
                        class="input-field w-full px-5 py-4 rounded-2xl text-gray-800 placeholder-gray-400 text-sm focus:outline-none"
                        placeholder="••••••••" />
                </div>

                <!-- Checkbox & Button -->
                <div class="space-y-6 pt-2">
                    <label class="flex items-center text-sm text-gray-600 cursor-pointer group">
                        <input type="checkbox"
                            class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 mr-3">
                        <span class="group-hover:text-gray-800 transition-colors">Giữ đăng nhập</span>
                    </label>

                    <button type="submit"
                        class="btn-modern w-full py-4 text-white font-semibold text-base rounded-2xl shadow-md tracking-wide">
                        Đăng nhập
                    </button>
                </div>
            </form>

            <p class="mt-8 text-center text-xs text-gray-500">
                © 2026 ADMIN SYSTEM BY
                <a href="https://www.facebook.com/huynhkha010" target="_blank"
                    class="text-indigo-600 hover:text-indigo-700 font-medium transition-colors">
                    @huynhkha
                </a>
            </p>
        </div>
    </div>

    <script>
        const loginForm = document.getElementById('loginForm');
        const errorMessage = document.getElementById('errorMessage');
        const submitBtn = document.getElementById('submitBtn');

        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            errorMessage.classList.add('hidden');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="inline-block animate-spin mr-2">&#8635;</span> Đang xử lý...';

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            try {
                const response = await fetch('/api/admin/auth/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email, password })
                });

                const result = await response.json();

                if (response.ok) {
                    // Redirect to dashboard, the cookie is already set by the server
                    window.location.href = '/admin/dashboard';
                } else {
                    console.error('Login failed:', result);
                    errorMessage.textContent = result.message || (result.errors ? Object.values(result.errors)[0][0] : 'Đăng nhập thất bại.');
                    errorMessage.classList.remove('hidden');
                }
            } catch (error) {
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