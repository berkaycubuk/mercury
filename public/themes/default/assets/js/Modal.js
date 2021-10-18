class Modal {
    constructor(identifier) {
        this.element = $(identifier);
    }

    open() {
        this.element.addClass('active');
    }

    close() {
        this.element.removeClass('active');
    }
}

function openModalWithDataID(id, func = null) {
    $("[data-modal-id='" + id + "']").toggleClass('active');

    if (func != null) {
        func();
    }
}
