function loadUpozila(district_id) {
    if (district_id) {
        $.ajax({
            url: "dashbord/loadUpazilaByDistrict",
            type: "get",
            dataType: "JSON",
            data: "district_id=" + district_id,
            success: function (response) {
                $("#upz_id").html(response);
            }
        });
    }
}