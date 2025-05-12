jQuery(function ($) {
    const table = $('#roster-edit-form'),
        form = table.closest('form')
    ;

    /* name day validation */
    (function () {
        const month = $('#roster_name_day-month'),
            day = $('#roster_name_day-day'),
            nameDay = $('#roster_name_day')

        month.on('change', function () {
            const monthVal = parseInt(month.val()),
                dayVal = parseInt(day.val()),
                lastDay = getLastDay(monthVal)

            day.attr('max', lastDay.toString())
            if (dayVal > lastDay) {
                day.val(lastDay.toString())
            }
            completeNameDay(validateFields())
        })

        day.on('change', function () {
            completeNameDay(validateFields())
        })

        const completeNameDay = (isValid) => {
            if (isValid) {
                nameDay.val(month.val() + '-' + day.val())
            } else {
                nameDay.val('')
            }
        }

        const getLastDay = (month) => {
            let day = 0

            switch (month) {
                case 1:
                case 3:
                case 5:
                case 7:
                case 8:
                case 10:
                case 12:
                    day = 31
                    break
                case 2:
                    day = 29
                    break
                case 4:
                case 6:
                case 9:
                case 11:
                    day = 30
                    break
            }

            return day
        }

        const validateFields = () => {
            const monthVal = parseInt(month.val()),
                dayVal = parseInt(day.val()),
                lastDay = getLastDay(monthVal)

            if ((isNaN(monthVal) && isNaN(dayVal)) || (0 === monthVal && 0 === dayVal)) {
                // valid
                month[0].setCustomValidity('')
                day[0].setCustomValidity('')
                form.removeClass('was-invalid')

                return true
            }

            if (0 < monthVal && monthVal < 12 && 0 < dayVal && dayVal <= lastDay) {
                // valid
                month[0].setCustomValidity('')
                day[0].setCustomValidity('')
                form.removeClass('was-invalid')

                return true
            }

            // invalid
            month[0].setCustomValidity('invalid month')
            day[0].setCustomValidity('invalid day')
            form.addClass('was-invalid')

            return false
        }
    })();

    /* image click */
    (function () {
        const image = $('img.profile-image-thumbnail'),
            popup = $('.image-popup'),
            popupImage = popup.find('img')

        image.on('click', function () {
            popupImage.attr('src', popupImage.data('src'))
            popup.removeClass('hidden')
        })

        popup.on('click', function () {
            popup.addClass('hidden')
        })
    })()
})