//=== test 24.05

(function () {
    class Backdrop {
        constructor() {
            this.body = document.body;
        }

        check() {
            return this.body.classList.contains('modal-open');
        }

        openModal() {
            const block = document.createElement('div');
            block.className = 'modal-backdrop fade';
            this.body.classList.add('modal-open');
            this.body.append(block);
            setTimeout(() => {
                block.classList.add('show')
            }, 160);
        }

        closeModal() {
            const b = document.querySelector('.modal-backdrop');
            b.classList.remove('show');
            setTimeout(() => {
                b.remove();
            }, 160);
            this.body.classList.remove('modal-open');
        }

        action() {
            if (this.check()) {
                this.closeModal();
            } else {
                this.openModal();
            }
        }
    }

    window.backdroup = new Backdrop();
}());