<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>EMS Portal Systems - Press Ctrl + P to Print</title>
        <script type='text/javascript' src='js/utilities.js'></script>
        <script type="text/javascript">
            function loadDocument(){
                var imageID = readCookie("theDoc");
                var imgsrc = document.getElementById('imgsrc');
                imgsrc.innerHTML = "<img src='documents/"+imageID.replace(/#/g,' ')+"' border='1' width='480' height='580' id='docfile' title='Document' alt='The document'/>";
            }


        </script>
    </head>
    <body>
        <div id="imgsrc">
            <img src="" border="1" width="480" id="docfile" height="580" title="Document" alt="The document"/>
        </div>
    </body>
</html>
<script type="text/javascript">
    loadDocument();
</script>