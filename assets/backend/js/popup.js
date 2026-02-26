class PopupWithSelect2 {
    constructor(options) {
        this.openBtn = document.querySelector(options.openBtn);
        this.popup = document.querySelector(options.popup);
        this.closeBtn = this.popup.querySelector(options.closeBtn);
        this.overlay = this.popup.querySelector('.popup-overlay');
        this.selectSelector = options.selectSelector;
        this.dropdownParentSelector = options.dropdownParent || '.popup-content';

        this.init();
    }

    init() {
        if (this.openBtn) {
            this.openBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.showPopup();
            });
        }

        if (this.closeBtn) {
            this.closeBtn.addEventListener('click', () => this.hidePopup());
        }

        if (this.overlay) {
            this.overlay.addEventListener('click', () => this.hidePopup());
        }
    }

    showPopup() {
        this.popup.style.display = 'flex';

        // Khởi tạo select2 sau khi popup hiển thị
        setTimeout(() => {
            const $select = jQuery(this.selectSelector);
            if (typeof jQuery.fn.select2 !== 'undefined') {
                // Nếu select2 đã được khởi tạo trước đó → hủy và tạo lại
                if ($select.hasClass('select2-hidden-accessible')) {
                    $select.select2('destroy');
                }

                $select.select2({
                    width: '100%',
                    dropdownParent: jQuery(this.dropdownParentSelector)
                });
            } else {
                console.warn('Select2 not loaded.');
            }
        }, 10);
    }

    hidePopup() {
        this.popup.style.display = 'none';
    }
}