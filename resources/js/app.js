require('./bootstrap');

import autosize from 'autosize'
import { chunk } from 'lodash';

import Toastify from 'toastify-js'
import "toastify-js/src/toastify.css"

const toastOption = {
    text: '',
    duration: 2000,
    position: "center",
    gravity: 'bottom',
    className: '',
    style: {
        zIndex: 99999,
    }
}

function formatMoney(element, callback = (value = '') => { }) {
    let value = $(element).val()

    let formattedValue = ''

    if (value.length > 3) {
        value = value.replace(/\./g, '')
        let arrVal = value.split('')
        arrVal.reverse()

        const chunkedVal = chunk(arrVal, 3)

        arrVal = []
        for (const arr of chunkedVal) {
            arr.reverse()
            arrVal.push(arr.join(''))
        }

        arrVal.reverse()

        formattedValue = arrVal.join('.')

        element.value = formattedValue
    }

    callback(formattedValue)
}

$(function () {
    const fullLoadingBox = $("#fullLoadingBox")

    autosize($('textarea'))
    $('textarea').css('min-height', "100px")

    $("[data-name='detail-section']").hide()
    $(`[data-section='${window.location.hash || '#informasi'}']`).show()
    $(`[data-link='${window.location.hash || '#informasi'}']`).tab('show')

    $('.tab-link').on('click', function (e) {
        // e.preventDefault()
        $(this).tab('show')
    })


    $('.tab-link').on('shown.bs.tab', function (event) {
        const dataLink = {
            related: event.relatedTarget.dataset.link,
            current: event.target.dataset.link
        }

        $(`[data-section='${dataLink.related}']`).hide(400)
        $(`[data-section='${dataLink.current}']`).show(400)
    })


    $('.nominal-btn').on('click', function () {
        $('.nominal-btn').addClass('btn-outline-secondary');
        $('.nominal-btn').removeClass('btn-secondary');
        $(this).removeClass('btn-outline-secondary')
        $(this).addClass('btn-secondary')
        if ($(this).data('value') === "other") {
            $("#nominalWrapper").show(400)
            $("#nominal").val(0)
        } else {
            $("#nominalWrapper").hide(400)
            $("#nominal").val($(this).data('value'))
        }
    })

    $("input.only-number").on('keydown', function (event) {
        const allowedKey = ['Backspace', 'Enter', 'Tab', 'ArrowRight', 'ArrowUp', 'ArrowLeft', 'ArrowDown']
        if (!event.ctrlKey && isNaN(event.key) && allowedKey.indexOf(event.key) === -1) {
            event.preventDefault()
        }
    })

    $("input.money-format").each(function () {
        formatMoney(this)
    })

    $('input.money-format').on('keyup', function (event) {
        let selectionStart = this.selectionStart
        let selectionEnd = this.selectionEnd

        const oldValue = this.value

        formatMoney(this, newValue => {
            if (newValue && newValue.length !== oldValue.length) {
                if (newValue.length > oldValue.length) {
                    selectionStart++
                    selectionEnd++
                } else {
                    if (selectionStart === 0 && selectionEnd === 0) {
                        selectionStart++
                        selectionEnd++
                    } else {
                        selectionStart--
                        selectionEnd--
                    }
                }
            }
        })

        this.setSelectionRange(selectionStart, selectionEnd)
    })

    $("form").on('submit', function (event) {
        $('input.money-format').each(function () {
            let val = this.value
            val = val.replace(/\./g, '')

            this.value = val
        })

        this.querySelector("button[type='submit']").setAttribute('disabled', 'disabled');
    })

    $("input[type='radio']").on('click', function () {
        if ($(this).hasClass('is-invalid')) {
            const inputName = this.getAttribute('name');

            $(`input[name='${inputName}']`).removeClass('is-invalid')
        }
    })

    $("button#donasi-disini").on('click', function () {
        $.scrollTo('section#galangan-terbaru', 300, {
            offset: -70,
            easing: 'linear'
        })
    });

    $(`label[for='bukti-gambar']`).on('click', function () {
        $("#bukti-gambar").val('')
    })

    $(".share-link-btn").on('click', function () {
        if (navigator.clipboard) {
            navigator.clipboard.writeText($(this).data('link'))
                .then(() => {
                    toastOption.className = 'toast-normal';
                    toastOption.text = 'Alamat galangan berhasil disalin'
                    Toastify(toastOption).showToast()
                })
        }
    })

    $('#bukti-gambar').on('change', function () {
        const campaignId = $("#campaign-id").val()
        const images = $(this).prop('files')

        const formData = new FormData()
        formData.append('_method', 'PUT')

        $.each(images, function (index, image) {
            formData.append(`gambar[${index}]`, image)
        })

        fullLoadingBox.css('display', 'block')
        $.ajax({
            url: `/campaigns/${campaignId}/bukti/gambar`,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (paths) {
                $.each(paths, function (index, path) {
                    $("#gambar-container").append(`<img src="${path}" alt="bukti-${campaignId}-${path.split('/').pop}" class="img-fluid mb-3" style="max-height:400px;" />`)
                })

                toastOption.text = 'Berhasil menambah gambar';
                toastOption.className = 'toast-success';
            },
            error: function (xhr, textStatus) {
                toastOption.text = textStatus
                toastOption.className = 'toast-error'
            },
            complete: function () {
                Toastify(toastOption).showToast()
                fullLoadingBox.css('display', 'none')
            }
        })
    })

    $("#tambahBuktiKomentarForm").on('submit', function (event) {
        event.preventDefault()

        const campaignId = $("#campaign-id").val()
        const submitButton = this.querySelector("button[type='submit']")

        submitButton.innerHTML = window.miniSpinner
        $.ajax({
            url: `/campaigns/${campaignId}/bukti/komentar`,
            method: 'PUT',
            data: {
                komentar: $("#bukti-komentar").val(),
            },
            success: function (data) {
                submitButton.innerHTML = 'Tambah'
                submitButton.removeAttribute('disabled');

                toastOption.text = 'Komentar berhasil ditambah';
                toastOption.className = 'toast-success';
            },
            error: function (xhr, textStatus) {
                toastOption.text = textStatus
                toastOption.className = 'toast-error';
            },
            complete: function () {
                submitButton.innerHTML = 'Tambah'
                submitButton.removeAttribute('disabled');
                Toastify(toastOption).showToast()
            }
        })

    })
})

