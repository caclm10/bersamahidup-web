function acceptOrReject(accept) {
    return function () {
        if (!accept && !confirm('Tolak ajuan ini?')) {
            return false;
        }

        const parent = $(this).parent()
        const campaignId = parent.data('campaign-id');

        parent.html(window.miniSpinner)

        $.ajax({
            url: `/admin/campaigns/${campaignId}/acceptance`,
            method: 'POST',
            dataType: 'json',
            data: { accept, '_method': "PATCH" },
            success: function () {
                if (accept) {
                    parent.html(`<span>Penggalangan ini telah diterima</span>`)
                } else {
                    $(`tr[data-campaign-id='${campaignId}']`).remove()
                }
            }
        })
    }
}

$(function () {
    $(".show-campaign-detail-button").on('click', function () {
        const campaignId = $(this).data('campaign-id');

        $("#campaignDetailBody").html(window.spinner)
        $.ajax({
            url: '/admin/campaigns/' + campaignId,
            method: 'GET',
            accepts: 'text/html',
            success: function (data) {
                $("#campaignDetailBody").html(data)
            }
        })
    })

    $(".accept-button").on('click', acceptOrReject(true))
    $(".reject-button").on('click', acceptOrReject(false))
})