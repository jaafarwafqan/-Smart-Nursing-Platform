
<footer class="footer-smart">
    <div class="footer-inner">
        {{-- العمود 1: نبذة --}}
        <div class="footer-col">
            <h5>منصة التمريض الذكية</h5>
            <p>
                نظام متكامل لإدارة الحملات والفعاليات والبحوث
                بكفاءة عالية وواجهة سهلة الاستخدام.
            </p>
            <div class="social-links">
                <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="https://twitter.com"  target="_blank"><i class="fab fa-twitter"></i></a>
                <a href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
            </div>
        </div>

        {{-- العمود 2: روابط سريعة --}}
        <div class="footer-col">
            <h5>روابط سريعة</h5>
            <ul>
                @can('manage_events')
                    <li><a href="{{ route('events.index') }}">الفعاليات</a></li>
                @endcan
                @can('manage_campaigns')
                    <li><a href="{{ route('campaigns.index') }}">الحملات</a></li>
                @endcan
                @can('manage_researches')
                    <li><a href="{{ route('researches.index') }}">البحوث</a></li>
                @endcan
                <li><a href="{{ route('about') }}">حول النظام</a></li>
            </ul>
        </div>

        {{-- العمود 3: تواصل معنا --}}
        <div class="footer-col">
            <h5>تواصل معنا</h5>
            <ul>
                <li>كلية التمريض – جامعة الكوفة</li>
                <li><i class="fas fa-envelope"></i> nursing@uokufa.edu.iq</li>
                <li><i class="fas fa-phone"></i> ‎+964 (0)781 000 0000</li>
            </ul>
        </div>
    </div>

    <div class="footer-bottom">
         كلية التمريض – جامعة الكوفة  &copy; {{ date('Y') }}
    </div>
</footer>
