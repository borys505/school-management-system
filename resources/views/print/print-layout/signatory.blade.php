            <p style="margin-top:40px; font-size: 14px;">{{trans('general.printed_on').' '.showDateTime(now())}}</p>
            <p style="text-align: right; font-size: 12px; font-weight: bold;">{{trans('general.authorized_signatory')}}</p>
        </div>
    </div>
</body>
<script src="https://www.skps.ac.in/imagesloaded.pkgd.min.js">
    </script>

<script type="text/javascript">
  imagesLoaded(document.body, function() {
    window.print();
  });
</script>
</html>