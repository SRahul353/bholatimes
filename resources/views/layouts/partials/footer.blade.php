@php
    if (!isset($categories)) {
        $categories = \App\Models\Category::has('posts')->limit(8)->get();
    }
@endphp

<!-- High-End Elegant Dark Footer -->
<footer class="main-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-column-left">
                <!-- Dynamic Footer Logo Option (Image logo or HTML text logo) -->
                <div class="footer-logo mb-3">
                    @if(!empty($themeSettings['footer_logo_image']))
                        <img src="{{ asset($themeSettings['footer_logo_image']) }}" alt="দৈনিক ভোলা টাইমস্" style="max-height: 52px; display: inline-block;">
                    @elseif(!empty($themeSettings['logo_image']))
                        <img src="{{ asset($themeSettings['logo_image']) }}" alt="দৈনিক ভোলা টাইমস্" style="max-height: 52px; display: inline-block;">
                    @else
                        <h2 class="footer-brand-title" style="margin-bottom: 0;">{!! $themeSettings['logo_text'] ?? 'দৈনিক ভোলা<span>টাইমস্</span>' !!}</h2>
                    @endif
                </div>
                
                <p class="footer-text">
                    {{ $themeSettings['footer_text'] ?? 'দৈনিক ভোলা টাইমস্ জেলার শীর্ষস্থানীয় একটি অনলাইন সংবাদপত্র। আমরা অত্যন্ত সততা, নিষ্ঠা ও নিরপেক্ষতার সাথে সব ধরণের স্থানীয় ও জাতীয় সংবাদ সবার আগে প্রকাশ করি।' }}
                </p>
                <div class="footer-social-icons">
                    <a href="{{ $themeSettings['social_facebook'] ?? '#' }}" target="_blank" class="footer-social-btn"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="{{ $themeSettings['social_twitter'] ?? '#' }}" target="_blank" class="footer-social-btn"><i class="fa-brands fa-twitter"></i></a>
                    <a href="{{ $themeSettings['social_youtube'] ?? '#' }}" target="_blank" class="footer-social-btn"><i class="fa-brands fa-youtube"></i></a>
                    <a href="{{ $themeSettings['social_instagram'] ?? '#' }}" target="_blank" class="footer-social-btn"><i class="fa-brands fa-instagram"></i></a>
                </div>
            </div>
            
            <div class="footer-column-right">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="footer-sec-title">যোগাযোগ</h4>
                        <ul class="footer-contact">
                            <li>
                                <i class="fa-solid fa-location-dot"></i>
                                <span>{{ $themeSettings['contact_address'] ?? 'বার্তা ও বাণিজ্যিক কার্যালয়- আমানত পাড়া, ভোলা।' }}</span>
                            </li>
                            <li>
                                <i class="fa-solid fa-phone"></i>
                                <span>{{ $themeSettings['contact_phone'] ?? '০১৭১১৪৬৯৫৩৯' }}</span>
                            </li>
                            <li>
                                <i class="fa-solid fa-envelope"></i>
                                <span>{{ $themeSettings['contact_email'] ?? 'news.bholatimes@gmail.com' }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6 mt-4 mt-md-0">
                        <h4 class="footer-sec-title">সম্পাদনা পর্ষদ</h4>
                        <div class="footer-editorial mt-0 pt-0" style="border-top: none;">
                            <p style="margin-bottom: 8px;"><strong>সম্পাদক মণ্ডলীর সভাপতি:</strong> {{ $themeSettings['editorial_board_president'] ?? 'সামস্-উল-আলম মিঠু' }}</p>
                            <p style="margin-bottom: 8px;"><strong>প্রধান সম্পাদক ও প্রকাশক:</strong> {{ $themeSettings['editorial_publisher'] ?? 'মোঃ আলী জিন্নাহ (রাজিব)' }}</p>
                            <p style="margin-bottom: 0;"><strong>ভারপ্রাপ্ত সম্পাদক:</strong> {{ $themeSettings['editorial_editor'] ?? 'মোঃ হেলাল উদ্দিন' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
           <p>&copy; {{ date('Y') }} {{ $themeSettings['copyright_text'] ?? 'দৈনিক ভোলা টাইমস্। সর্বস্বত্ব সংরক্ষিত।' }}</p>
           <p>ডিজাইন ও ডেভেলপমেন্ট: Antigravity AI</p>
        </div>
    </div>
</footer>

<!-- Interactive Logic Scripts -->
<script>
    // Set formatted date in Bengali
    document.addEventListener('DOMContentLoaded', function() {
        const dateSpan = document.getElementById('currentDate');
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const banglaDateFormatter = new Intl.DateTimeFormat('bn-BD', options);
        if(dateSpan) dateSpan.textContent = banglaDateFormatter.format(new Date());

        // Premium Bengali Calendar Date display (Revised Bangladeshi Calendar 2019)
        const banglaDateSpan = document.getElementById('banglaDate');
        if (banglaDateSpan) {
            function getBanglaDate(date) {
                const d = date ? new Date(date) : new Date();
                const day = d.getDate();
                const month = d.getMonth() + 1;
                const year = d.getFullYear();
                const isLeapYear = (year % 4 === 0 && year % 100 !== 0) || (year % 400 === 0);
                const banglaMonths = [
                    "বৈশাখ", "জ্যৈষ্ঠ", "আষাঢ়", "শ্রাবণ", "ভাদ্র", "আশ্বিন",
                    "কার্তিক", "অগ্রহায়ণ", "পৌষ", "মাঘ", "ফাল্গুন", "চৈত্র"
                ];
                const toBanglaNumber = num => {
                    const bnNums = ["০", "১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯"];
                    return num.toString().split("").map(d => bnNums[d] || d).join("");
                };
                let bnDay, bnMonth, bnYear;
                const gregDays = [0, 31, isLeapYear ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
                let dayOfYear = 0;
                for (let i = 1; i < month; i++) {
                    dayOfYear += gregDays[i];
                }
                dayOfYear += day;
                const boishakhDayOfYear = 31 + (isLeapYear ? 29 : 28) + 31 + 14;
                if (dayOfYear >= boishakhDayOfYear) {
                    bnYear = year - 593;
                    dayOfYear -= boishakhDayOfYear;
                } else {
                    bnYear = year - 594;
                    const prevLeapYear = ((year - 1) % 4 === 0 && (year - 1) % 100 !== 0) || ((year - 1) % 400 === 0);
                    const prevYearDays = 365 + (prevLeapYear ? 1 : 0);
                    const lastBoishakhDayOfYear = 31 + (prevLeapYear ? 29 : 28) + 31 + 14;
                    dayOfYear = dayOfYear + prevYearDays - lastBoishakhDayOfYear;
                }
                const monthDays = [31, 31, 31, 31, 31, 30, 30, 30, 30, 30, isLeapYear ? 31 : 30, 30];
                let accum = 0;
                for (let i = 0; i < 12; i++) {
                    if (dayOfYear < accum + monthDays[i]) {
                        bnDay = dayOfYear - accum + 1;
                        bnMonth = i;
                        break;
                    }
                    accum += monthDays[i];
                }
                return `${toBanglaNumber(bnDay)} ${banglaMonths[bnMonth]} ${toBanglaNumber(bnYear)} বঙ্গাব্দ`;
            }
            banglaDateSpan.textContent = getBanglaDate(new Date());
        }

        // Drawer Toggle Logic
        const drawer = document.getElementById('mobileDrawer');
        const overlay = document.getElementById('siteOverlay');

        function toggleDrawer() {
            drawer.classList.toggle('open');
            overlay.classList.toggle('show');
        }

        // Attach event listener to all open elements (both desktop and mobile hamburger buttons)
        const openButtons = document.querySelectorAll('.mobile-menu-toggle, #openDrawer, #openDrawerMobile');
        openButtons.forEach(btn => {
            btn.addEventListener('click', toggleDrawer);
        });

        const closeBtn = document.getElementById('closeDrawer');
        if(closeBtn) closeBtn.addEventListener('click', toggleDrawer);
        if(overlay) overlay.addEventListener('click', toggleDrawer);
    });
</script>

<!-- Bootstrap 5.3.3 JS Bundle CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
