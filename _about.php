		<link href="images/global00.css" rel="stylesheet" type="text/css" media="all">
       
<!-- MODULE Home Featured Products -->
<script type="text/javascript">

$(document).ready(function()
    {
        $('.wrapfirstword').each(function() {
            var h = $(this).html();
            var index = h.indexOf(' ');
            if(index == -1) {
                index = h.length;
            }
            $(this).html('<span>' + h.substring(0, index) + '</span>' + h.substring(index, h.length));
        });
    });

</script>
<div id="featured_products">
	<h4 class="wrapfirstword">����� ���������� �� ��� ����!</h4>
	<div class="block_content">
		<p style="padding:10px 10px 10px 10px ">
������ � ����� ������������ �������� ��������� ������, ����� �� �� ������� ���������� ���������. � ���������� ����� ���������� ����� �������, ���������� �������������� ��������, ������� ���������� � �������������� �������. ���� ��� ���������, ��� ������ Toyota ��� Lexus ����� ����� �����������, �� �� - �������� AvtoPolit ����������� ������ ���. </p>
		<div class="clearblock"></div>
	</div>
</div>
    <!-- /MODULE Home Featured Products -->		