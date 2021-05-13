(function () {
    "use strict";
    require('select2/dist/js/select2.full.min');


    $(document).ready(function () {
        const container = document.querySelector('div.container-delivery-form');

        let defaultSelect2Options = {
            "language": {
                "noResults": function () {
                    return "Нічого не знайдено";
                }
            }
            //placeholder: 'Select an option',
            //theme: "bootstrap"
            //theme : "classic"
        };
        let Select2Cascade = function Select2Cascade(parent, child, url, select2Options) {
            select2Options = select2Options || {};
            let afterActions = [],
                _setOptions = function (node, options) {
                    let result = [{
                        'id': '',
                        'text': '',
                        'alt': ''
                    }];
                    if (node.attr("data-select2-id")) {
                        node.select2('destroy');
                    }
                    if (options.length !== 0) {
                        for (var index in options) {
                            let obj = {
                                'id': options[index]['ref'],
                                'text': options[index]['full_name'],
                                'alt': options[index]['name']
                            };
                            result.push(obj);
                        }

                    }
                    node.html('').prop("disabled", options.length === 0).select2($.extend({}, select2Options, {data: result})).trigger("change");
                };

            // Register functions to be called after cascading data loading done
            this.then = function (callback) {
                afterActions.push(callback);
                return this;
            };

            parent.select2(select2Options).on("change", function (e) {
                let _url = (typeof url == "function") ? url() : url;

                _setOptions(child, []);
                if (!parent.val() || parent.val().length === 0) {
                    return;
                }
                child.parent().addClass("loading");
                $.getJSON(_url.replace(':parentId:', $(this).val()), function (items) {
                    _setOptions(child, items);

                    afterActions.forEach(function (callback) {
                        callback(parent, child, items);
                    });

                    child.parent().removeClass("loading");
                });
            });
        };
        let Select2CustomMatcher = function (params, data) {
            // Always return the object if there is nothing to compare
            if ($.trim(params.term) === '') {
                return data;
            }

            // Do a recursive check for options with children
            if (data.children && data.children.length > 0) {
                // Clone the data object if there are children
                // This is required as we modify the object to remove any non-matches
                let match = $.extend(true, {}, data);

                // Check each child of the option
                for (let c = data.children.length - 1; c >= 0; c--) {
                    let child = data.children[c];

                    let matches = matcher(params, child);

                    // If there wasn't a match, remove the object in the array
                    if (matches == null) {
                        match.children.splice(c, 1);
                    }
                }

                // If any children matched, return the new object
                if (match.children.length > 0) {
                    return match;
                }

                // If there were no matching children, check just the plain object
                return matcher(params, match);
            }

            let alt = removeDiacritics(data.alt || data.element.dataset.alt || "").toUpperCase(),
                original = removeDiacritics(data.text).toUpperCase(),
                term = removeDiacritics(params.term).toUpperCase();

            // Check if the text contains the term
            if (original.indexOf(term) > -1 || alt.indexOf(term) > -1) {
                return data;
            }

            // If it doesn't contain the term, don't return anything
            return null;
        };

        $("div.container-delivery-form").each(function (index, container) {
            let delivery = 'new_mail',//container.dataset.delivery,
                delivery_service = 'new_mail',//container.dataset.delivery,
                select2Options = {...defaultSelect2Options, width: '100%', matcher: Select2CustomMatcher},
                $region = $("#" + delivery + "_region"),
                $city = $("#" + delivery + "_city"),
                $delivery_type = $("#" + delivery + "_delivery_type");//"#" + delivery + "_delivery_type"


            if (!($region && $city)) {
                return;
            }

            new Select2Cascade(
                $region,
                $city,
                function () {
                    return '/new-post/:parentId:/settlements';
                },
                select2Options
            );
            new Select2Cascade(
                $city,
                $("#" + delivery + "_warehouse").select2(select2Options),
                '/new-post/:parentId:/warehouses',
                select2Options
            );

            new Select2Cascade(
                $city,
                $("#" + delivery + "_street").select2(select2Options),
                '/np/city/:parentId:/streets',
                select2Options
            );

            $("#" + delivery + "_warehouse, #" + delivery + "_street").on("change", function () {
                $("#" + delivery + "_delivery_type").trigger("change", true);
            });
        });


        let csrfToken = document.querySelector('#csrf-token').value;
        var url = `/new-post/areas`;
        var xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);
        xhr.onload = function ({currentTarget}) {
            let response = JSON.parse(currentTarget.response);
            let result = [{
                'id': '',
                'text': '',
                'alt': ''
            }];

            if (response.length !== 0) {
                for (var index in response) {
                    let obj = {
                        'id': response[index]['ref'],
                        'text': response[index]['full_name'],
                        'alt': response[index]['name']
                    };
                    result.push(obj);
                }
            }

            $('.js-example-basic-single1').html('').select2($.extend({}, {
                ...defaultSelect2Options,
                width: '100%',
                matcher: Select2CustomMatcher
            }, {data: result}));

        };
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
        xhr.send();


        const deliveryType = document.querySelector('#new_mail_delivery_type');
        const action = {
            'storage_storage': {
                'new_mail_warehouse' : false,
                'new_mail_street' : true,
                'new_mail_house' : true,
                'new_mail_apartment' : true
            },
            'storage_door' : {
                'new_mail_warehouse' : true,
                'new_mail_street' : false,
                'new_mail_house' : false,
                'new_mail_apartment' : false

            }
        };
        deliveryType.addEventListener('change', function ({target}) {
            const value = target.value;
            for(let id  in action[value]) {
                container.querySelector(`#${id}`).parentElement.hidden = action[value][id];
            }
        });

    });
}());