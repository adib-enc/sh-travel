<style>
    .result {
        background-color:#FEC606;
        font-weight:bold
    }
</style>
<section id="company-information" class="wow fadeIn" data-wow-duration="1000ms" data-wow-delay="300ms">
    <div class="container">
        <h1>
            Rekomendasi wahana
        </h1>
        <div class="row">
            <div class="col-lg-6">
                <form id="form" action="#">
                    <div class="form-group">
                        <label>Umur</label>
                        <input class="form-control" type="text" name="umur">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <input class="form-control" type="text" name="status">
                    </div>
                    <div class="form-group">
                        <label>Rombongan</label>
                        <input class="form-control" type="text" name="rombongan">
                    </div>
                    <div class="form-group">
                        <label>Hobi</label>
                        <input class="form-control" type="text" name="hobi">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary">Ambil rekomendasi</button>
                    </div>
                </form>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Rekomendasi</label>
                    <textarea class="form-control result" name="result">-</textarea>
                </div>
            </div>
        </div>
    </div>
</section>

@script
<script>
    let routes = {
        predictRecom: gl.baseurl + "home/predictRecom"
    }

    async function getPred({
        umur, status, rombongan, hobi
    }) {
        let fm = new FormData()
        fm.append("umur", umur)
        fm.append("status", status)
        fm.append("rombongan", rombongan)
        fm.append("hobi", hobi)

        return await ajaxer.post(routes.predictRecom, fm)
    }

    $("#form").on('submit', async function(e){
        e.preventDefault()

        let res = await getPred({
            umur: $("[name=umur]").val(), 
            status: $("[name=status]").val(), 
            rombongan: $("[name=rombongan]").val(), 
            hobi: $("[name=hobi]").val()
        })

        $("[name=result]").text( JSON.stringify(res) )
    })
</script>
@endscript