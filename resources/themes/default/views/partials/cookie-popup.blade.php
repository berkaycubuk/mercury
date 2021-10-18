<div class="cookie-popup">
    <div class="cookie-popup__content">
        <p>
            Sitemizdeki deneyiminizi iyileştirmek için çerezleri (cookie) kullanıyoruz.
        </p>
        <div class="cookie-popup__content__buttons">
            <button onclick="closePopup(event)">Anladım</button> 
            <a href="/cerez-politikasi">Çerez Politikamız</a>
        </div>
    </div>
</div>

@push('scripts')

<script>
    $(document).ready(function() {
        var popupState = false;

        if (getCookie('cookiePopup') != "") {
            console.log(getCookie('cookiePopup'));
            popupState = getCookie('cookiePopup');
        } else {
            setCookie('cookiePopup', "false");
        }

        if (!popupState) {
            $(".cookie-popup").toggleClass('visible');
        }
    });

    function closePopup(event) {
        event.preventDefault();
        $(".cookie-popup").toggleClass('visible');
        setCookie('cookiePopup', "true");
    }
</script>

@endpush
