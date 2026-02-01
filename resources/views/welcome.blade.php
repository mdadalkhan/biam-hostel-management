<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BIAM Feedback System</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        input[type="radio"].exc:checked + label { border-color: #10b981; background-color: #10b98133; }
        input[type="radio"].good:checked + label { border-color: #3b82f6; background-color: #3b82f633; }
        input[type="radio"].fair:checked + label { border-color: #facc15; background-color: #facc1533; }
        input[type="radio"].poor:checked + label { border-color: #ef4444; background-color: #ef444433; }
        .rating-label { display: inline-block; width: 1.25rem; height: 1.25rem; border-radius: 50%; border: 2px solid #cbd5e1; cursor: pointer; transition: all 0.2s ease; }
        input[type="radio"] { display: none; }
        .spinner { width: 18px; height: 18px; border: 2px solid rgba(255, 255, 255, 0.3); border-radius: 50%; border-top-color: #fff; animation: spin 0.8s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body 
    class="bg-slate-100 min-h-screen flex items-center justify-center p-2 md:p-4 antialiased"
    x-data="feedbackHandler()"
    x-init="startTimer()"
    @mousemove="resetTimer()"
    @keydown="resetTimer()"
    @touchstart="resetTimer()"
>
    <div class="bg-white shadow-2xl rounded-sm p-4 md:p-6 w-full max-w-7xl border border-slate-200">
        
        <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 border-b border-slate-100 pb-4 gap-4">
            <div class="flex items-center gap-3">
                <div class="flex-shrink-0 bg-white w-12 h-12 rounded-lg border border-slate-200 flex items-center justify-center shadow-sm">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-8 h-8 object-contain" />
                </div>
                <div>
                    <h1 class="text-lg md:text-xl font-extrabold text-slate-800 tracking-tight uppercase leading-none">BIAM Foundation</h1>
                    <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mt-1">Guest Feedback System v1.0</p>
                    <p class="inline-block px-2 py-0.5 text-[9px] font-bold text-red-500 bg-red-50 rounded-full border border-red-100 mt-1">
                        Auto refresh after: <span x-text="600 - timer"></span>s
                    </p>
                </div>
            </div>

            <div class="flex items-center">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold text-slate-500 hover:text-blue-600 uppercase tracking-wider px-3 py-2 border rounded border-slate-200 transition-colors">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="flex items-center gap-2 px-4 py-2 text-xs font-bold text-slate-600 uppercase tracking-wider border border-slate-200 rounded-md hover:bg-slate-50 hover:text-blue-600 transition-all shadow-sm bg-white">
                        Signin
                    </a>
                @endauth
            </div>
        </header>

        <form @submit.prevent="submitFeedback">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                <div class="lg:col-span-4 space-y-4">
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                        <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b pb-2 mb-3">Guest Details</h3>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 mb-1 uppercase">Room <span class="text-red-500">*</span></label>
                                <input type="text" name="room_number" required class="w-full px-3 py-1.5 text-sm rounded border border-slate-300 outline-none" />
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 mb-1 uppercase">Phone</label>
                                <input 
                                    type="tel" 
                                    name="phone" 
                                    x-model="formData.phone"
                                    @input="formData.phone = formData.phone.replace(/[^0-9]/g, '')"
                                    :class="phoneError ? 'border-red-500' : 'border-slate-300'"
                                    class="w-full px-3 py-1.5 text-sm rounded border outline-none" 
                                />
                                <p x-show="phoneError" x-cloak class="text-[8px] text-red-600 font-bold mt-1">Must be 11 digits</p>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-[10px] font-bold text-slate-600 mb-1 uppercase">Full Name</label>
                                <input type="text" name="name" class="w-full px-3 py-1.5 text-sm rounded border border-slate-300 outline-none" />
                            </div>
                            <div class="col-span-2">
                                <label class="block text-[10px] font-bold text-slate-600 mb-1 uppercase">Designation</label>
                                <input type="text" name="designation" class="w-full px-3 py-1.5 text-sm rounded border border-slate-300 outline-none" />
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 mb-1 uppercase ml-1">Suggestions</label>
                        <textarea name="suggestion" rows="2" class="w-full px-3 py-2 text-sm rounded border border-slate-300 outline-none resize-none shadow-inner"></textarea>
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
                                <tr 
                                    class="transition-colors"
                                    :class="errors.includes('{{ $key }}') ? 'bg-red-50' : 'hover:bg-blue-50/30'"
                                >
                                    <td class="px-4 py-3">
                                        <div class="text-[12px] font-bold text-slate-700 leading-tight">{{ $label }}</div>
                                        <div x-show="errors.includes('{{ $key }}')" x-cloak class="text-[8px] text-red-600 font-bold uppercase mt-1">Selection Required</div>
                                    </td>
                                    @foreach([4=>'exc', 3=>'good', 2=>'fair', 1=>'poor'] as $val => $class)
                                    <td class="text-center py-2">
                                        <input type="radio" id="{{ $key }}_{{ $class }}" name="{{ $key }}" value="{{ $val }}" class="{{ $class }}" @change="removeError('{{ $key }}')" />
                                        <label for="{{ $key }}_{{ $class }}" class="rating-label"></label>
                                    </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <template x-if="status === 'success'">
                        <div class="flex items-center gap-3 mt-4 p-4 bg-white border-l-4 border-green-500 shadow-md rounded-r-lg">
                            <span class="text-sm font-semibold text-gray-800">Feedback submitted successfully.</span>
                        </div>
                    </template>

                    <template x-if="status === 'error'">
                        <div class="flex items-center gap-3 mt-4 p-4 bg-white border-l-4 border-red-500 shadow-md rounded-r-lg">
                            <span class="text-sm font-semibold text-gray-800" x-text="errorMessage"></span>
                        </div>
                    </template>

                    <button 
                        type="submit" 
                        :disabled="loading"
                        class="mt-4 w-full py-3 bg-blue-700 text-white text-sm font-black rounded-lg hover:bg-blue-800 shadow-lg uppercase tracking-widest transition-all flex items-center justify-center gap-3"
                    >
                        <div x-show="loading" class="spinner"></div>
                        <span x-text="loading ? 'Sending...' : 'Submit Feedback'"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function feedbackHandler() {
            return {
                timer: 0,
                loading: false,
                status: null,
                errorMessage: '',
                errors: [],
                formData: { phone: '' },
                
                get phoneError() {
                    return this.formData.phone.length > 0 && this.formData.phone.length !== 11;
                },

                startTimer() {
                    setInterval(() => {
                        this.timer++;
                        if (this.timer >= 600) location.reload();
                    }, 1000);
                },

                resetTimer() { this.timer = 0; },

                removeError(key) {
                    this.errors = this.errors.filter(e => e !== key);
                },

                async submitFeedback(e) {
                    this.errors = [];
                    const form = e.target;
                    const data = new FormData(form);
                    
                    // Validate Ratings
                    const ratingKeys = {!! json_encode(array_keys($services)) !!};
                    ratingKeys.forEach(key => {
                        if (!data.get(key)) this.errors.push(key);
                    });

                    if (this.errors.length || this.phoneError) {
                        document.querySelector('.bg-red-50')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        return;
                    }

                    this.loading = true;
                    this.status = null;

                    try {
                        const response = await fetch('{{ route("sendfeedback") }}', {
                            method: 'POST',
                            headers: { 
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json' 
                            },
                            body: data
                        });
                        
                        const res = await response.json();
                        
                        if (res.status === 'success') {
                            this.status = 'success';
                            form.reset();
                            this.formData.phone = '';
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                            setTimeout(() => this.status = null, 5000);
                        } else {
                            this.status = 'error';
                            this.errorMessage = res.message || 'Validation Error';
                        }
                    } catch (err) {
                        this.status = 'error';
                        this.errorMessage = 'Server Connection Failed.';
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }
    </script>
</body>
</html>