$('.filer_input').filer({
    showThumbs: true,
    addMore: true,
    allowDuplicates: false,

    captions: {
        ru: {
            button: "Выберите файлы",
            feedback: "Выберите файлы для загрузки",
            feedback2: "файлы были выбраны",
            drop: "Перетащите файл сюда, чтобы загрузить",
            removeConfirmation: "Вы уверены, что хотите удалить файл ?",
            errors: {
                filesLimit: "Максимальное количество файлов: {{fi-limit}}.",
                filesType: "Only Images are allowed to be uploaded.",
                filesSize: "{{fi-name}} слишком большого размера! Пожалуйста загрузите файл не более {{fi-fileMaxSize}} MB.",
                filesSizeAll: "Выбранные файлы занимают слишком много места! Максимальный размер всех файлов {{fi-maxSize}} MB.",
                folderUpload: "Вам не разрешено загружать папки."
            }
        },
        uk: {
            button: "Оберіть файли",
            feedback: "Оберіть файли для завантаження",
            feedback2: "файли були обрані",
            drop: "Перетягніть файл сюди, щоб завантажити",
            removeConfirmation: "Ви впевнені, що хочете видалити файл ?",
            errors: {
                filesLimit: "Максимальна кількість файлів: {{fi-limit}}.",
                filesType: "Only Images are allowed to be uploaded.",
                filesSize: "{{fi-name}} занадто великого розміру! Будь ласка завантажте файл не більше {{fi-fileMaxSize}} MB.",
                filesSizeAll: "Вибрані файли займають занадто багато місця! Максимальний розмір всіх файлів {{fi-maxSize}} MB.",
                folderUpload: "Ви не дозволено завантажувати папки."
            }
        }
    }
});

$('.reply-comment-show').click(function (event) {
    event.preventDefault();
    $(this).next().toggle();
})

let inputs = $('.email-comment, .phone-comment');

inputs.on('input', function () {
    // Set the required property of the other input to false if this input is not empty.
    inputs.not(this).prop('required', !$(this).val().length);
});
