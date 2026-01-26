<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>BIAM Feedback System</title>
        <link rel="icon" type="image/png" href="images/logo.png" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            input[type="radio"].exc:checked + label {
                border-color: #10b981;
                background-color: #10b98133;
            }
            input[type="radio"].good:checked + label {
                border-color: #3b82f6;
                background-color: #3b82f633;
            }
            input[type="radio"].fair:checked + label {
                border-color: #facc15;
                background-color: #facc1533;
            }
            input[type="radio"].poor:checked + label {
                border-color: #ef4444;
                background-color: #ef444433;
            }
            .rating-label {
                display: inline-block;
                width: 1.25rem;
                height: 1.25rem;
                border-radius: 50%;
                border: 2px solid #cbd5e1;
                cursor: pointer;
                transition: all 0.2s ease;
            }
            input[type="radio"] {
                display: none;
            }
            .spinner {
                display: none;
                width: 18px;
                height: 18px;
                border: 2px solid rgba(255, 255, 255, 0.3);
                border-radius: 50%;
                border-top-color: #fff;
                animation: spin 0.8s linear infinite;
            }
            @keyframes spin {
                to { transform: rotate(360deg); }
            }
            button:disabled {
                opacity: 0.7;
                cursor: not-allowed;
            }
        </style>
    </head>
    <body class="bg-slate-100 min-h-screen flex items-center justify-center p-2 md:p-4 antialiased">
        <div class="bg-white shadow-2xl rounded-sm p-4 md:p-6 w-full max-w-7xl border border-slate-200">
            <header class="flex justify-between items-center mb-4 border-b border-slate-100 pb-4">
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0 bg-white w-12 h-12 rounded-lg border border-slate-200 flex items-center justify-center shadow-sm">
                        <img src="images/logo.png" alt="Logo" class="w-8 h-8 object-contain" />
                    </div>
                    <div>
                        <h1 class="text-lg md:text-xl font-extrabold text-slate-800 tracking-tight uppercase leading-none">
                            BIAM Foundation
                        </h1>
                        <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mt-1">
                            Guest Feedback System v1.0
                        </p>
                        <p class="inline-block px-2 py-0.5 text-[9px] font-bold text-red-500 bg-red-50 rounded-full border border-red-100 mt-1" id="inactive">
                            Auto refresh after: 600s
                        </p>
                    </div>
                </div>
            </header>

            <form id="feedbackForm">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    <div class="lg:col-span-4 space-y-4">
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                            <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b pb-2 mb-3">
                                Guest Details
                            </h3>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-600 mb-1 uppercase">Room <span class="text-red-500">*</span></label>
                                    <input type="numbers" name="room_number" placeholder="No." required class="w-full px-3 py-1.5 text-sm rounded border border-slate-300 focus:border-blue-500 outline-none" />
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-600 mb-1 uppercase">Phone</label>
                                    <input type="tel" id="phone" name="phone" placeholder="01XXX..." maxlength="11" class="w-full px-3 py-1.5 text-sm rounded border border-slate-300 focus:border-blue-500 outline-none" />
                                    <p id="phoneError" class="hidden text-[8px] text-red-600 font-bold mt-1">Must be 11 digits</p>
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-[10px] font-bold text-slate-600 mb-1 uppercase">Full Name</label>
                                    <input type="text" name="name" placeholder="Guest Name" class="w-full px-3 py-1.5 text-sm rounded border border-slate-300 focus:border-blue-500 outline-none" />
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-[10px] font-bold text-slate-600 mb-1 uppercase">Designation / Cadre ID</label>
                                    <input type="text" name="designation" placeholder="Designation" class="w-full px-3 py-1.5 text-sm rounded border border-slate-300 focus:border-blue-500 outline-none" />
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 mb-1 uppercase ml-1">Suggestions</label>
                            <textarea name="comment" rows="2" placeholder="How can we improve?" class="w-full px-3 py-2 text-sm rounded border border-slate-300 focus:ring-2 focus:ring-blue-500/10 outline-none resize-none shadow-inner"></textarea>
                        </div>
                    </div>

                    <div class="lg:col-span-8">
                        <div class="overflow-hidden border border-slate-200 rounded-sm shadow-sm bg-white">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-slate-800 text-white">
                                    <tr class="text-[10px] uppercase font-bold tracking-widest">
                                        <th class="px-4 py-2.5">Service Category</th>
                                        <th class="text-center w-14 text-green-400">Excellent</th>
                                        <th class="text-center w-14 text-blue-300">Good</th>
                                        <th class="text-center w-14 text-yellow-300">Fair</th>
                                        <th class="text-center w-14 text-red-400">Poor</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @php 
                                    $services = [
                                        'rating_front_desk_service' => 'Front Desk Service', 
                                        'rating_canteen_food' => 'Canteen Food Quality',
                                        'rating_canteen_staff_service' => 'Canteen Staff Behavior', 
                                        'rating_room_boys_service' => 'Room Boys Service',
                                        'rating_cleanliness_of_room' => 'Cleanliness of the Room',
                                        'rating_overall_cleanliness_around_room' => 'Overall Cleanliness of Surroundings',
                                        'rating_washroom_ac_lights_fan' => 'Washroom, AC, Lights, and Fans' 
                                    ]; 
                                    @endphp
                                    @foreach($services as $key => $label)
                                    <tr class="rating-row hover:bg-blue-50/30 transition-colors">
                                        <td class="px-4 py-3">
                                            <div class="text-[12px] font-bold text-slate-700 leading-tight">{{ $label }}</div>
                                            <div class="error-text hidden text-[8px] text-red-600 font-bold uppercase mt-1">Selection Required</div>
                                        </td>
                                        <td class="text-center py-2">
                                            <input type="radio" id="{{ $key }}_exc" name="{{ $key }}" value="4" class="exc" />
                                            <label for="{{ $key }}_exc" class="rating-label"></label>
                                        </td>
                                        <td class="text-center py-2">
                                            <input type="radio" id="{{ $key }}_good" name="{{ $key }}" value="3" class="good" />
                                            <label for="{{ $key }}_good" class="rating-label"></label>
                                        </td>
                                        <td class="text-center py-2">
                                            <input type="radio" id="{{ $key }}_fair" name="{{ $key }}" value="2" class="fair" />
                                            <label for="{{ $key }}_fair" class="rating-label"></label>
                                        </td>
                                        <td class="text-center py-2">
                                            <input type="radio" id="{{ $key }}_poor" name="{{ $key }}" value="1" class="poor" />
                                            <label for="{{ $key }}_poor" class="rating-label"></label>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div id="successToast" class="hidden flex items-center gap-3 mt-4 mb-4 p-4 bg-white border-l-4 border-green-500 shadow-md rounded-r-lg transition-all duration-300">
                            <div class="flex-shrink-0 text-green-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div class="text-sm font-semibold text-gray-800 tracking-tight">
                                Feedback submitted successfully. <span class="text-green-600">Thank you!</span>
                            </div>
                        </div>

                        <button type="submit" id="submitBtn" class="mt-4 w-full py-3 bg-blue-700 text-white text-sm font-black rounded-lg hover:bg-blue-800 shadow-lg uppercase tracking-widest transition-all flex items-center justify-center gap-3">
                            <div id="btnSpinner" class="spinner"></div>
                            <span id="btnText">Submit Feedback</span>
                        </button>
                    </div>
                </div>
            </form>
            <p class="text-xs font-medium text-slate-600 leading-relaxed text-center mt-4">
                Developed and maintained by <span class="text-blue-700 font-semibold">Department of ICT</span> (BIAM Foundation)
            </p>
        </div>

        <script>
            const form = document.getElementById("feedbackForm");
            const rows = document.querySelectorAll(".rating-row");
            const phoneInput = document.getElementById("phone");
            const phoneError = document.getElementById("phoneError");
            const successToast = document.getElementById("successToast");
            const p = document.getElementById("inactive");
            const submitBtn = document.getElementById("submitBtn");
            const btnSpinner = document.getElementById("btnSpinner");
            const btnText = document.getElementById("btnText");

            phoneInput.addEventListener("input", () => {
                phoneInput.value = phoneInput.value.replace(/[^0-9]/g, "");
                if (phoneInput.value.length > 0 && phoneInput.value.length !== 11) {
                    phoneInput.classList.add("border-red-500");
                    phoneError.classList.remove("hidden");
                } else {
                    phoneInput.classList.remove("border-red-500");
                    phoneError.classList.add("hidden");
                }
            });

            form.addEventListener("submit", function (e) {
                e.preventDefault();
                let hasError = false;
                let firstError = null;

                rows.forEach((row) => {
                    if (!row.querySelector('input[type="radio"]:checked')) {
                        row.classList.add("bg-red-50");
                        row.querySelector(".error-text").classList.remove("hidden");
                        hasError = true;
                        if (!firstError) firstError = row;
                    } else {
                        row.classList.remove("bg-red-50");
                        row.querySelector(".error-text").classList.add("hidden");
                    }
                });

                if (phoneInput.value.length > 0 && phoneInput.value.length !== 11) {
                    phoneInput.classList.add("border-red-500");
                    phoneError.classList.remove("hidden");
                    hasError = true;
                    if (!firstError) firstError = phoneInput;
                }

                if (hasError) {
                    if (firstError) firstError.scrollIntoView({ behavior: "smooth", block: "center" });
                    return;
                }

                submitBtn.disabled = true;
                btnSpinner.style.display = "block";
                btnText.textContent = "Sending...";
                successToast.classList.add("hidden");

                fetch('{{ route("SendFeedback") }}', {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                    },
                    body: new FormData(form),
                })
                .then((res) => res.json())
                .then((res) => {
                    submitBtn.disabled = false;
                    btnSpinner.style.display = "none";
                    btnText.textContent = "Submit Feedback";
                    if (res.satisfaction_percentage) {
                        successToast.classList.remove("hidden");
                        form.reset();
                        rows.forEach((r) => {
                            r.classList.remove("bg-red-50");
                            r.querySelector(".error-text").classList.add("hidden");
                        });
                        phoneInput.classList.remove("border-red-500");
                        phoneError.classList.add("hidden");
                        window.scrollTo({ top: 0, behavior: "smooth" });
                        setTimeout(() => successToast.classList.add("hidden"), 5000);
                    } else {
                        alert(res.message);
                    }
                })
                .catch((err) => {
                    submitBtn.disabled = false;
                    btnSpinner.style.display = "none";
                    btnText.textContent = "Submit Feedback";
                    alert("Submission failed.");
                });
            });

            let count = 0;
            const MAX_INACTIVITY = 600;
            function Activity() {
                count += 1;
                p.textContent = `Auto refresh after: ${MAX_INACTIVITY - count}s`;
                if (count >= MAX_INACTIVITY) {
                    clearInterval(timer);
                    location.reload();
                }
            }
            let timer = setInterval(Activity, 1000);
            function resetInactivity() {
                clearInterval(timer);
                count = 0;
                p.textContent = `Auto refresh after: ${MAX_INACTIVITY}s`;
                timer = setInterval(Activity, 1000);
            }
            window.onmousemove = resetInactivity;
            window.onkeydown = resetInactivity;
        </script>
    </body>
</html>