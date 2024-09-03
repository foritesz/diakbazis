$(document).ready(function() {
    var totalRecord = 0;
    var totalData = $("#totalRecords").val();
    var loading = false;

    function loadProducts() {
        var subcategory = getCheckboxValues('subcategory');
        var search = $("#myInput").val();

        $.ajax({
            type: 'POST',
            url: "config/load_products.php",
            dataType: "json",
            data: {
                totalRecord: totalRecord,
                subcategory: subcategory,
                search: search
            },
            beforeSend: function() {
                $("#loadMoreButton").text("Loading...").prop("disabled", true);
                $('.loader').show();
            },
            success: function(data) {
                $("#results").append(data.products);
                $(".skeleton").removeClass("skeleton"); // Remove the skeleton class
                totalRecord++;
                loading = false;
                $('.loader').hide();
                if (totalRecord >= totalData) {
                    $("#loadMoreButton").hide();
                } else {
                    $("#loadMoreButton").show().text("Load More").prop("disabled", false);
                }
            },
            error: function() {
                $("#loadMoreButton").text("Load More").prop("disabled", false);
                $('.loader').hide();
            }
        });
    }

    $('#searchForm').submit(function(e) {
        e.preventDefault();

        totalRecord = 0;
        $("#results").empty();
        loadProducts();
    });

    $("#loadMoreButton").click(function() {
        if (!loading && totalRecord < totalData) {
            loading = true;
            loadProducts();
        }
    });

    $(window).scroll(function() {
        var scrollHeight = parseInt($(window).scrollTop() + $(window).height());
        if (scrollHeight == $(document).height() && !loading && totalRecord < totalData) {
            loading = true;
            loadProducts();
        }
    });

    function getCheckboxValues(checkboxClass) {
        var values = [];
        $("." + checkboxClass + ":checked").each(function() {
            values.push($(this).val());
        });
        return values;
    }

    $('.sort_rang').change(function() {
        $("#searchForm").submit();
        return false;
    });

    $(document).on('click', 'label', function() {
        if ($('input:checkbox:checked', this)) {
            $(this).closest('label').addClass('active');
        }
    });

    // Initial load
    loadProducts();
});
