'use strict'
class Notify {
    constructor(config = {}) {
        this.message = config.message || '';
        this.type = config.type || 'success';

        // Khởi động hệ thống
        this.init();
    }

    /**
     * Khởi tạo sự kiện và hiển thị toast nếu có message từ PHP
     */
    init() {
        jQuery(document).ready(() => {
            // Nếu có message từ PHP (qua wp_localize_script)
            if (this.message) {
                this.show(this.message, this.type);

                // Xóa msg và type khỏi URL sau khi hiển thị
                const url = new URL(window.location.href);
                url.searchParams.delete('msg');
                url.searchParams.delete('type');
                const cleanUrl = url.pathname + url.search + url.hash;
                window.history.replaceState({}, document.title, cleanUrl);
            }

            // Gắn instance ra global để module khác có thể gọi
            window.internNotifications = this;

            // Tự động bind sự kiện cho nút xoá
            this.bindDeleteButtons();
        });
    }

    /**
     * Hiển thị một thông báo Toastify
     * @param {string} msg - nội dung thông báo
     * @param {string} type - loại thông báo: success | error | info | warning
     */
    show(msg, type = 'success') {
        if (!msg) return;

        let bg = '#4CAF50';
        if (type === 'error') bg = '#f44336';
        if (type === 'info') bg = '#2196F3';
        if (type === 'warning') bg = '#FF9800';

        Toastify({
            text: msg,
            duration: 3500,
            close: true,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
            style: { background: bg },
        }).showToast();
    }

    /**
     * Gọi API hoặc AJAX async với Axios
     * @param {string} url - endpoint
     * @param {object} data - dữ liệu gửi đi
     * @param {string} successMsg - thông báo khi thành công
     * @param {string} errorMsg - thông báo khi lỗi
     */
    async post(url, data = {}, successMsg = '', errorMsg = '') {
        try {
            const response = await axios.post(url, data);
            if (response.data && response.data.success) {
                if (successMsg) this.show(successMsg, 'success');
                return response.data;
            } else {
                const msg = response.data?.message || errorMsg || 'Đã xảy ra lỗi!';
                this.show(msg, 'error');
                throw new Error(msg);
            }
        } catch (error) {
            console.error('❌ Lỗi POST:', error);
            this.show(errorMsg || 'Lỗi kết nối máy chủ!', 'error');
            throw error;
        }
    }

    /**
     * Gọi API GET async với Axios
     * @param {string} url
     * @param {string} successMsg
     * @param {string} errorMsg
     */
    async get(url, successMsg = '', errorMsg = '') {
        try {
            const response = await axios.get(url);
            if (response.data && response.data.success) {
                if (successMsg) this.show(successMsg, 'success');
                return response.data;
            } else {
                const msg = response.data?.message || errorMsg || 'Đã xảy ra lỗi!';
                this.show(msg, 'error');
                throw new Error(msg);
            }
        } catch (error) {
            console.error('❌ Lỗi GET:', error);
            this.show(errorMsg || 'Lỗi kết nối máy chủ!', 'error');
            throw error;
        }
    }

    /**
     * 🔹 Hiển thị popup thông báo bằng SweetAlert2
     * @param {string} title
     * @param {string} text
     * @param {string} type
     */
    alert(title = 'Thông báo', text = '', type = 'info') {
        Swal.fire({
            title: title,
            text: text,
            icon: type,
            confirmButtonText: 'OK',
        });
    }

    /**
     * 🔸 Hiển thị popup xác nhận có Yes / No
     * @param {string} title
     * @param {string} text
     * @param {function} onConfirm
     */
    confirm(title = 'Bạn có chắc không?', text = '', onConfirm = null) {
        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Đồng ý',
            cancelButtonText: 'Hủy bỏ',
        }).then((result) => {
            if (result.isConfirmed && typeof onConfirm === 'function') {
                onConfirm();
            }
        });
    }

    /**
     * 🔹 Hiển thị prompt nhập dữ liệu
     * @param {string} title
     * @param {function} callback
     */
    prompt(title = 'Nhập dữ liệu', callback = null) {
        Swal.fire({
            title: title,
            input: 'text',
            inputPlaceholder: 'Nhập nội dung...',
            showCancelButton: true,
            confirmButtonText: 'Gửi',
            cancelButtonText: 'Hủy',
            inputValidator: (value) => {
                if (!value) {
                    return 'Vui lòng nhập nội dung!';
                }
            }
        }).then((result) => {
            if (result.isConfirmed && typeof callback === 'function') {
                callback(result.value);
            }
        });
    }

    /**
     * 🔥 Confirm xoá (tái sử dụng nhiều module)
     * Gắn sẵn cho các nút có class `.btn-delete`
     * Hỗ trợ AJAX hoặc redirect
     */
    bindDeleteButtons() {
        const self = this;
        jQuery(document).on('click', '.btn-delete', function (e) {
            e.preventDefault();

            const $btn = jQuery(this);
            const url = jQuery(this).attr('href');
            const name = jQuery(this).data('name') || 'mục này';
            const row = $btn.closest('tr, .col'); // dòng <tr> chứa nút

            // Nếu nút có data-ajax="false" => dùng redirect truyền thống
            const useAjax = $btn.data('ajax') !== false;

            self.confirmDelete('Xác nhận xoá', name, url, row, useAjax);
        });
    }

    /**
     * 🔸 Hàm confirm xoá tái sử dụng
     * Hỗ trợ AJAX hoặc redirect
     */
    confirmDelete(title, name, url, row = null, useAjax = true) {
        Swal.fire({
            title: title,
            html: `Bạn có chắc chắn muốn xoá <b>${name}</b>?<br>Hành động này không thể hoàn tác.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Đồng ý xoá',
            cancelButtonText: 'Huỷ bỏ',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
        }).then( async (result) => {
            if (!result.isConfirmed) return;

            // Loading khi xử lý
            Swal.fire({
                title: 'Đang xử lý...',
                text: 'Vui lòng chờ giây lát',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => Swal.showLoading(),
            });

            if (useAjax) {
                try {
                    const res = await axios.get(url);
                    if (res.data.success) {
                        Swal.close();
                        this.show('Đã xoá thành công!', 'success');
                        if (row && row.length) row.fadeOut(300, () => row.remove());
                    } else {
                        Swal.close();
                        this.show(res.data.message || 'Không thể xoá dữ liệu.', 'error');
                    }
                } catch (error) {
                    Swal.close();
                    this.show('Lỗi khi gửi yêu cầu xoá!', 'error');
                    console.error(error);
                }
            } else {
                // Redirect
                window.location.href = url;
            }
        });
    }

}

// ✅ Tự động khởi tạo global instance khi trang load
(function() {
    // Dữ liệu PHP truyền qua wp_localize_script
    const cfg = typeof internNotifications !== 'undefined'
        ? internNotifications
        : {};

    window.internNotifications = new Notify(cfg);
})();
