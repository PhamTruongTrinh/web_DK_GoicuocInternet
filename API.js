const host = "https://provinces.open-api.vn/api/";
var callAPI = (api) => {
    return axios.get(api)
        .then((response) => {
            renderData(response.data, "province");
        });
}
callAPI('https://provinces.open-api.vn/api/?depth=1');
var callApiDistrict = (api) => {
    return axios.get(api)
        .then((response) => {
            renderData(response.data.districts, "district");
        });
}
var callApiWard = (api) => {
    return axios.get(api)
        .then((response) => {
            renderData(response.data.wards, "ward");
        });
}

var renderData = (array, select) => {
    let row = ' <option disable value="">chọn</option>';
    array.forEach(element => {
        row += `<option value="${element.code}">${element.name}</option>`;
    });
    document.querySelector("#" + select).innerHTML = row;
}

$("#province").change(() => {
    callApiDistrict(host + "p/" + $("#province").val() + "?depth=2");
    updateInputValue("provinceInput", $("#province option:selected").text());
    printResult();
});

$("#district").change(() => {
    callApiWard(host + "d/" + $("#district").val() + "?depth=2");
    updateInputValue("districtInput", $("#district option:selected").text());
    printResult();
});

$("#ward").change(() => {
    updateInputValue("wardInput", $("#ward option:selected").text());
    printResult();
});

var updateInputValue = (inputId, value) => {
    $("#" + inputId).val(value);
}

var printResult = () => {
    if ($("#district").val() != "" && $("#province").val() != "" &&
        $("#ward").val() != "") {
        let result = $("#province option:selected").text() +
            " | " + $("#district option:selected").text() + " | " +
            $("#ward option:selected").text();
        $("#result").text(result)
        /////////////////////////////////////////////////
        let tinh = $("#province option:selected").text();
        let huyen = $("#district option:selected").text();
        let xa = $("#ward option:selected").text();
        $("#tinh").text(tinh)
        $("#huyen").text(huyen)
        $("#xa").text(xa)
    }
}