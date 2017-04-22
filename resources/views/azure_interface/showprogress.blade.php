

<!--header-->
{{"The remaining time :".$pr}}

<script>
    document.getElementById("formatRaid").onclick=function(){
        var xhr = new XMLHttpRequest();
        xhr.addEventListener("progress", function(evt) {
            var lines = evt.currentTarget.response.split("\n");
            if(lines.length)
                var progress = lines[lines.length-1];
            else
                var progress = 0;
            document.getElementById("progress").innerHTML = progress;
        }, false);
        xhr.open('POST', "getProgress.php", true);
        xhr.send();
    }
</script>


