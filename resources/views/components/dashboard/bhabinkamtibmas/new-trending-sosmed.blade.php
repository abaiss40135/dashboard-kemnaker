@push('styles')
    <style>
        .word {
            display: inline-block;
            margin: 2px;
            font-size: 1em;
        }

        .card-trending-sosmed {
            padding-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #social-media-trend {
            max-height: 75vh;
            overflow-y: scroll;
        }
    </style>
@endpush
<div class="card">
    <div class="card-header">
        Trend Sosial Media
        <div class="card-tools">
            <div class="btn-group show">
                <button type="button" class="btn btn-blue btn-sm dropdown-toggle" data-toggle="dropdown">
                    <i class="fas fa-bars"></i>
                </button>
                <div id="dropdown-sosmed" class="dropdown-menu" role="menu">
{{--                    <a href="#trending-keyword" class="dropdown-item" data-source="twitter">Twitter</a>--}}
                    <a href="#trending-keyword" class="dropdown-item" data-source="google">Google</a>
                    <a href="#trending-keyword" class="dropdown-item" data-source="youtube">YouTube</a>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body card-trending-sosmed">
        <div id="social-media-trend" class="w-100 text-center">
{{--            <div id="social-media-trend" class="w-100 text-center"><a class="word text-success" href="http://twitter.com/search?q=%22orang+islam+cinta+ilmu%22" style="font-size: undefinedpx" target="_blank" data-count="5">orang islam cinta ilmu</a><a class="word text-primary" href="http://twitter.com/search?q=%22prabowo+kerja+terbaik%22" style="font-size: 30px" target="_blank" data-count="3">prabowo kerja terbaik</a><a class="word text-success" href="http://twitter.com/search?q=Ferdy" style="font-size: undefinedpx" target="_blank" data-count="2">Ferdy</a><a class="word text-success" href="http://twitter.com/search?q=%22Angkatan+Darat+Di+Hati+Rakyat%22" style="font-size: undefinedpx" target="_blank" data-count="2">Angkatan Darat Di Hati Rakyat</a><a class="word text-success" href="http://twitter.com/search?q=%23BacalegPKB" style="font-size: 20px" target="_blank" data-count="6">#BacalegPKB</a><a class="word text-success" href="http://twitter.com/search?q=%23GusMuhaiminIskandar" style="font-size: 20px" target="_blank" data-count="1">#GusMuhaiminIskandar</a><a class="word text-success" href="http://twitter.com/search?q=%22Pak+Prabowo%22" style="font-size: undefinedpx" target="_blank" data-count="8">Pak Prabowo</a><a class="word text-success" href="http://twitter.com/search?q=Esemka" style="font-size: undefinedpx" target="_blank" data-count="1">Esemka</a><a class="word text-success" href="http://twitter.com/search?q=%22jinny+concept+photo%22" style="font-size: undefinedpx" target="_blank" data-count="5">jinny concept photo</a><a class="word text-danger" href="http://twitter.com/search?q=%23WishWINWonderful24th" style="font-size: 36px" target="_blank" data-count="4">#WishWINWonderful24th</a><a class="word text-success" href="http://twitter.com/search?q=Senin" style="font-size: undefinedpx" target="_blank" data-count="3">Senin</a><a class="word text-warning" href="http://twitter.com/search?q=%23OurMiracleWendyDay" style="font-size: 24px" target="_blank" data-count="1">#OurMiracleWendyDay</a><a class="word text-success" href="http://twitter.com/search?q=%22the+boyz+roar-ing+comeback%22" style="font-size: undefinedpx" target="_blank" data-count="6">the boyz roar-ing comeback</a><a class="word text-success" href="http://twitter.com/search?q=%22solo+of+nct%22" style="font-size: undefinedpx" target="_blank" data-count="6">solo of nct</a><a class="word text-success" href="http://twitter.com/search?q=Pagar" style="font-size: undefinedpx" target="_blank" data-count="9">Pagar</a></div>--}}
        </div>
    </div>
</div>
@push('scripts')
    <script type="text/javascript" src="https://ssl.gstatic.com/trends_nrtr/2884_RC01/embed_loader.js"></script>
    <script>
        // Script fetch trending twitter
        var words = [];

        // A $( document ).ready() block.
        $(document).ready(function () {
            $("#social-media-trend").html(preloader);
            getGoogleTrends();
        });

        $('#dropdown-sosmed .dropdown-item').on('click', function () {
            console.log($(this).data('source'));
            switch ($(this).data('source')) {
                case 'youtube':
                    getYoutubeTrends()
                    break;
                case 'google':
                    getGoogleTrends()
                    break;
                case 'twitter':
                    getTwitterTrends();
                    break;
            }
        })

        let getTwitterTrends = () => {
            let url = route('get-twitter.indonesia-trends');
            @if(role('operator_bhabinkamtibmas_polda'))
                url = '{{ route('get-twitter.indonesia-trends', ['polda' => auth()->user()->personel->polda]) }}'
            @endif

            axios.get(url, {}).then(function (response) {
                $('#social-media-trend').addClass('text-center');
                words = response.data[0].trends.map(function (value, index, array) {
                    return {"title": value.name, "url": value.url};
                });
                placeWordsOnMap();
            }).catch(function (error) {
                console.log(error);
            })
        }

        let getYoutubeTrends = () => {
            axios.get(route('get-youtube.get-trending-indonesia'), {}).then(function (response) {
                let htmlOutput = [];
                let fontColor = ['danger', 'primary', 'primary', 'primary', 'warning', 'warning', 'warning', 'success', 'success', 'success'];
                for (let key = 0; key < response.data.length; key++) {
                    let youtube = response.data[key];
                    htmlOutput[key] = `
                            <a href="${youtube.url}" target="_blank" class="text-dark">
                                <div class="card mb-2 border">
                                  <div class="row no-gutters">
                                    <div class="col-md-1 d-flex align-items-center justify-content-center">
                                      <span class="text-bold">${key+1}</span>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-center">
                                      <img src="${youtube.thumbnail}" class="card-img" alt="thumbnail">
                                    </div>
                                    <div class="col-md-7">
                                      <div class="card-body">
                                        <h5 class="card-title text-${fontColor[key] ?? 'success'}">${youtube.title}</h5>
                                        <p class="card-text">${youtube.owner}</p>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            </a>`;
                }
                $("#social-media-trend").html(htmlOutput);
                $('#social-media-trend').removeClass('text-center');
            }).catch(function (error) {
                console.log(error);
            })
        }

        let getGoogleTrends = () => {
            $('#social-media-trend').html(`<iframe id="trends-widget-3" title="trends-widget-3" src="https://trends.google.com/trends/embed/dailytrends?forceMobileMode=false&amp;isPreviewMode=true&amp;hl=in&geo=ID" width="100%" frameborder="0" scrolling="0" style="border-radius: 2px; box-shadow: rgba(0, 0, 0, 0.12) 0px 0px 2px 0px, rgba(0, 0, 0, 0.24) 0px 2px 2px 0px; height: 75vh;"></iframe>`);
            $('#social-media-trend').removeClass('text-center');
        }

        function placeWordsOnMap(sort = true) {
            let htmlOutput = [];
            let fontSize = [36, 30, 30, 30, 24, 24, 24, 20, 20, 20];
            let fontColor = ['danger', 'primary', 'primary', 'primary', 'warning', 'warning', 'warning', 'success', 'success', 'success'];
            for (let wordsI = 0; wordsI < words.length; wordsI++) {
                let word = words[wordsI];
                let randomInt = randomIntFromInterval(1, 10);
                htmlOutput[wordsI] = '<a class="word text-' + (fontColor[wordsI] ?? 'success') + '" href="' + word.url + '" style="font-size: ' + fontSize[wordsI] + 'px" target="_blank" data-count="' +
                    randomInt +
                    '">' +
                    word.title +
                    "</a>";
            }
            $("#social-media-trend").html(sort ? htmlOutput.sort(() => Math.random() - 0.5).join("") : htmlOutput);
        }

        function stylizeWords() {
            var maxSize = 3;
            var minSize = 1;
            var wordsInListing = $("#social-media-trend").find("div.word");
            var maxWordCount = 0;

            // first get the max word count
            wordsInListing.each(function () {
                var count = $(this).data("count");
                if (count > maxWordCount) {
                    maxWordCount = count;
                }
            });

            wordsInListing.each(function () {
                var count = $(this).data("count");
                var ratioForStyle = round(maxSize * count / maxWordCount, 2);
                $(this).css("font-size", ratioForStyle + "em");
            });
        }
    </script>
@endpush
