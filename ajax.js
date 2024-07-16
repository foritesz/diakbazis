
$(document).ready(function() {
	
    var totalRecord = 0;
    var subcategory = getCheckboxValues('subcategory');
    var totalData = $("#totalRecords").val();
	var search = $("#myInput").val(); // Hozzáadott sor: Keresési érték lekérése

    $.ajax({
        type: 'POST',
        url: "../load_products.php",
        dataType: "json",
        data: {
            totalRecord: totalRecord,
            subcategory: subcategory,
            search: search // Hozzáadott sor: Keresési érték továbbítása
        },
        success: function(data) {
            $("#results").append(data.products);
            totalRecord++;
        }
    });
	$('#searchForm').submit(function(e) {
        e.preventDefault(); // Prevent the form from submitting in the traditional way

        var searchValue = $('#myInput').val();
        totalRecord = 0; // Reset totalRecord when performing a new search
        $("#results").empty(); // Clear existing results

        $.ajax({
            type: 'POST',
            url: "../load_products.php",
            dataType: "json",
            data: {
                totalRecord: totalRecord,
                subcategory: getCheckboxValues('subcategory'),
                search: searchValue
            },
            success: function(data) {
                $("#results").append(data.products);
                totalRecord++;
            }
        });
    });
    $(window).scroll(function() {
		scrollHeight = parseInt($(window).scrollTop() + $(window).height());		
        if(scrollHeight == $(document).height()){	
            if(totalRecord <= totalData){
                loading = true;
                $('.loader').show();                
				$.ajax({
					type: 'POST',
					url : "../load_products.php",
					dataType: "json",			
					data:{totalRecord:totalRecord,subcategory:subcategory},
					success: function (data) {
						$("#results").append(data.products);
						$('.loader').hide();
						totalRecord++;
					}
				});
            }            
        }
    });
    function getCheckboxValues(checkboxClass){
        var values = new Array();
		$("."+checkboxClass+":checked").each(function() {
		   values.push($(this).val());
		});
        return values;
    }
    $('.sort_rang').change(function(){
        $("#search_form").submit();
        return false;
    });
	$(document).on('click', 'label', function() {
		if($('input:checkbox:checked')) {
			$('input:checkbox:checked', this).closest('label').addClass('active');
		}
	})
	
});

