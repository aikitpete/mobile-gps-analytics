var currentPage = 1;
var resultsPage = 20;
var lastPage;

$(document).ready(function() {

	submitData(currentPage, resultsPage);
	

});

function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

function submitData(currentPage, resultsPage) {
	$.ajax({
		url: "usage.php?limit="+resultsPage+"&page="+currentPage,
		success: function(html) {
			
			var result = JSON.parse(html);
			
			var table = "";
			
			
			if (result.meta.current>1) {
				table = table + '<a href="javascript:void();" onclick="firstPage()">FIRST</a>   <a href="javascript:void();" onclick="previousPage()">PREVIOUS</a>   ';
			}
			
			table = table + "Page "+result.meta.current+" of "+result.meta.total+' go to   <input type="textbox" id="pagenr"/>   show   <input type="textbox" id="pagetot" value="'+result.meta.page+'"/>   results per page   <input type="submit" onclick="updatePage()" value=" Submit "></input> <input type="submit" onclick="refreshPage()" value=" Refresh "></input>';
			
			if (result.meta.current!=result.meta.total) {
				table = table + '   <a href="javascript:void();" onclick="nextPage()">NEXT</a>   <a href="javascript:void();" onclick="laPage()">LAST</a>';
			}
			
			lastPage = result.meta.total;
			
			table = table + '<table  id="dataTable" class="tablesorter" ><thead>';
			
			table = table + "<tr>";
			
			table = table + "<th>" + "" + "</th>";
			
		    for (var i = 0 ; i < result.headers.length ; i++) {
		        var header = result.headers[i];
		        table = table + "<th>" + header + "</th>";
		    }
			table = table + "</tr>";
			
			table = table + "</thead><tbody>";
			
		    for (var i = 0 ; i < result.data.length ; i++) {
				table = table + "<tr>";
				table = table + "<td>" + '<a href="javascript:void(0)" onclick="deleteRecord('+result.data[i][0]+')">Delete</a>' + "</td>";
				for (var j = 0 ; j < result.data[i].length ; j++) {
					var header = result.data[i][j];
		        	table = table + "<td>" + header + "</td>";
				}
				table = table + "</tr>";
		    }
			
			table = table + "</tbody></table>";
			
			if (result.meta.current>1) {
				table = table + '<a href="javascript:void();" onclick="firstPage()">FIRST</a>   <a href="javascript:void();" onclick="previousPage()">PREVIOUS</a>   ';
			}
			
			table = table + "Page "+result.meta.current+" of "+result.meta.total+' go to   <input type="textbox" id="pagenr"/>   show   <input type="textbox" id="pagetot" value="'+result.meta.page+'"/>   results per page   <input type="submit" onclick="updatePage()" value=" Submit "></input> <input type="submit" onclick="refreshPage()" value=" Refresh "></input>';
			
			if (result.meta.current!=result.meta.total) {
				table = table + '   <a href="javascript:void();" onclick="nextPage()">NEXT</a>   <a href="javascript:void();" onclick="laPage()">LAST</a>';
			}
			
			document.getElementById("data").innerHTML = table;
			
			$("#dataTable").tablesorter(); 
			
		}
	});
}

function deleteRecord(record) {
	$.ajax({
		url: "usage.php?action=delete&id="+record,
		success: function(html) {
			submitData(currentPage, resultsPage);
		}
	});
	
}

function updatePage() {
	if (isNumber($("#pagenr").val())) {
		currentPage = $("#pagenr").val();
	}
	if (isNumber($("#pagetot").val())) {
		resultsPage = $("#pagetot").val();
	}
	submitData(currentPage, resultsPage);
}

function refreshPage() {
	submitData(currentPage, resultsPage);
}

function gotoPage() {
	submitData(currentPage, resultsPage);
}

function firstPage() {
	currentPage=1;
	submitData(currentPage, resultsPage);
}

function laPage() {
	currentPage=lastPage;
	submitData(currentPage, resultsPage);
}

function nextPage() {
	currentPage++;
	submitData(currentPage, resultsPage);
}

function previousPage() {
	currentPage--;
	submitData(currentPage, resultsPage);
}

/*
function buildHtmlTable() {
    var columns = addAllColumnHeaders(jsonObj);

    for (var i = 0 ; i < jsonObj.length ; i++) {
        var row$ = $('<tr/>');
        for (var colIndex = 0 ; colIndex < columns.length ; colIndex++) {
            var cellValue = jsonObj[i][columns[colIndex]];

            if (cellValue == null) { cellValue = ""; }

            row$.append($('<td/>').html(cellValue));
        }
        $("#excelDataTable").append(row$);
    }
}

function addAllColumnHeaders(jsonObj)
{
    var columnSet = [];
    var headerTr$ = $('<tr/>');

    for (var i = 0 ; i < jsonObj.length ; i++) {
        var rowHash = jsonObj[i];
        for (var key in rowHash) {
            if ($.inArray(key, columnSet) == -1){
                columnSet.push(key);
                headerTr$.append($('<th/>').html(key));
            }
        }
    }
    $("#excelDataTable").append(headerTr$);

    return columnSet;
}​
*/