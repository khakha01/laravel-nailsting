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
            transform: translateY(-1.5px);
            box-shadow: 0 12px 24px -8px rgba(99, 102, 241, 0.35);
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
            <h1 class="text-3xl font-bold text-gray-800">CMS Admin</h1>
            <p class="text-sm text-gray-500">Content Management System</p>
        </div>

        <div class="glass-card rounded-3xl p-10 animate-fade">
            <form id="loginForm" class="space-y-6">

                <div>
                    <label class="text-xs font-semibold text-gray-600 ml-1">Email quản trị</label>
                    <input type="email" id="email" required class="input-field w-full px-5 py-4 rounded-2xl text-sm"
                        placeholder="admin@gmail.vn" />
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-600 ml-1">Mật khẩu</label>
                    <input type="password" id="password" required
                        class="input-field w-full px-5 py-4 rounded-2xl text-sm" placeholder="••••••••" />
                </div>

                <label class="flex items-center text-sm text-gray-600">
                    <input type="checkbox" id="remember" class="mr-3">
                    Giữ đăng nhập
                </label>

                <!-- ERROR MESSAGE -->
                <div id="errorMessage"
                    class="hidden text-sm text-red-600 bg-red-50 border border-red-200 rounded-xl p-3 text-center">
                </div>

                <button type="submit" id="submitBtn"
                    class="btn-modern w-full py-4 text-white font-semibold rounded-2xl">
                    Đăng nhập
                </button>
            </form>
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
            submitBtn.innerHTML = 'Đang xử lý...';

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const remember = document.getElementById('remember').checked;


            try {
                const response = await fetch('/api/{{ config('app.admin_prefix') }}/auth/login', {
                    method: 'POST',
                    credentials: 'include',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email, password, remember })
                });

                const result = await response.json();

                if (response.ok) {
                    window.location.href = '/{{ config('app.admin_prefix') }}/dashboard';
                } else {
                    errorMessage.textContent = result.message || 'Đăng nhập thất bại';
                    errorMessage.classList.remove('hidden');
                }
            } catch {
                errorMessage.textContent = 'Lỗi hệ thống, thử lại sau';
                errorMessage.classList.remove('hidden');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerText = 'Đăng nhập';
            }
        });
    </script>

</body>

</html>