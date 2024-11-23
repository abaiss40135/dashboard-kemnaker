@push('styles')
    <style>
        .word {
            display: inline-block;
            margin: 2px;
            font-size: 1em;
        }

        .card-popular-keyword {
            padding-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #popular-keyword {
            max-height: 75vh;
            overflow-y: scroll;
        }
    </style>
@endpush
<div class="card">
    <div class="header card-header card-title">
        Trend Laporan
    </div>
    <div class="card-body card-popular-keyword">
        {{-- <div id="popular-keyword" class="w-100 text-center"></div> --}}
        <div id="popular-keyword-mockup" class="w-100 text-center"><a class="btn p-0 ml-2 popular-keyword text-primary" style="font-size: 30px !important" data-count="15235"> covid</a><a class="btn p-0 ml-2 popular-keyword text-success" style="font-size: undefinedpx !important" data-count="10042"> covid-19</a><a class="btn p-0 ml-2 popular-keyword text-warning" style="font-size: 24px !important" data-count="14483"> covid 19</a><a class="btn p-0 ml-2 popular-keyword text-success" style="font-size: undefinedpx !important" data-count="4687"> jalan rusak</a><a class="btn p-0 ml-2 popular-keyword text-success" style="font-size: 20px !important" data-count="11422"> kamtibmas</a><a class="btn p-0 ml-2 popular-keyword text-success" style="font-size: undefinedpx !important" data-count="4799"> aman</a><a class="btn p-0 ml-2 popular-keyword text-success" style="font-size: 20px !important" data-count="11808"> jalan</a><a class="btn p-0 ml-2 popular-keyword text-success" style="font-size: undefinedpx !important" data-count="6764"> sumber</a><a class="btn p-0 ml-2 popular-keyword text-success" style="font-size: undefinedpx !important" data-count="6718"> saat</a><a class="btn p-0 ml-2 popular-keyword text-success" style="font-size: 20px !important" data-count="11966"> sambang</a><a class="btn p-0 ml-2 popular-keyword text-primary" style="font-size: 30px !important" data-count="17350"> ekonomi</a><a class="btn p-0 ml-2 popular-keyword text-success" style="font-size: undefinedpx !important" data-count="5505"> vaksinasi</a><a class="btn p-0 ml-2 popular-keyword text-success" style="font-size: undefinedpx !important" data-count="8144"> patroli</a><a class="btn p-0 ml-2 popular-keyword text-warning" style="font-size: 24px !important" data-count="13274"> desa</a><a class="btn p-0 ml-2 popular-keyword text-success" style="font-size: undefinedpx !important" data-count="6260"> sosial</a><a class="btn p-0 ml-2 popular-keyword text-success" style="font-size: undefinedpx !important" data-count="10563"> prokes</a><a class="btn p-0 ml-2 popular-keyword text-success" style="font-size: undefinedpx !important" data-count="5226"> pencurian</a><a class="btn p-0 ml-2 popular-keyword text-warning" style="font-size: 24px !important" data-count="13029"> pandemi</a><a class="btn p-0 ml-2 popular-keyword text-success" style="font-size: undefinedpx !important" data-count="4474"> kesehatan</a><a class="btn p-0 ml-2 popular-keyword text-success" style="font-size: undefinedpx !important" data-count="11174"> vaksin</a><a class="btn p-0 ml-2 popular-keyword text-success" style="font-size: undefinedpx !important" data-count="5736"> masker</a><a class="btn p-0 ml-2 popular-keyword text-success" style="font-size: undefinedpx !important" data-count="5894"> dds</a><a class="btn p-0 ml-2 popular-keyword text-primary" style="font-size: 30px !important" data-count="15245"> bhabinkamtibmas</a><a class="btn p-0 ml-2 popular-keyword text-success" style="font-size: undefinedpx !important" data-count="5055"> kunjungan</a><a class="btn p-0 ml-2 popular-keyword text-success" style="font-size: undefinedpx !important" data-count="5343"> nihil</a><a class="btn p-0 ml-2 popular-keyword text-success" style="font-size: undefinedpx !important" data-count="5269"> himbauan</a><a class="btn p-0 ml-2 popular-keyword text-success" style="font-size: undefinedpx !important" data-count="5182"> pemerintah</a><a class="btn p-0 ml-2 popular-keyword text-danger" style="font-size: 36px !important" data-count="17621"> keamanan</a><a class="btn p-0 ml-2 popular-keyword text-success" style="font-size: undefinedpx !important" data-count="5340"> sambang patroli dialogis</a><a class="btn p-0 ml-2 popular-keyword text-success" style="font-size: undefinedpx !important" data-count="4530"> covid19</a></div>
    </div>
</div>
@push('scripts')
    <script>
        // Script fetch trending twitter
        var words = [];

        // A $( document ).ready() block.
        $(document).ready(function () {
            // getPopularKeywordLaporan();
        });

        function initPencarianPopular(){
            $('.popular-keyword').click(function (event) {
                //destroyMap();

                let data = SEARCH_STATE.data;
                Object.assign(data, {
                    keyword: keyword = $(this).html().trimLeft()
                });
                filterDashboard(Object.assign(SEARCH_STATE, {
                    url: URL_FILTER_DASHBOARD,
                    data: data,
                    type: 'filter-keyword'
                }));

                $('#pagination-laporan').twbsPagination('destroy');
                scrollDownTo('laporan-list');
            });
        }

        function generateKeywordPopularList(data) {
            let popular = $('#popular-keyword');
            popular.html("");
            let htmlOutput = [];

            if (data.length > 0) {
                let keywords = data;
                let fontSize = [36, 30, 30,30, 24, 24, 24, 20, 20, 20];
                let fontColor = ['danger', 'primary', 'primary', 'primary','warning', 'warning', 'warning', 'success', 'success', 'success'];
                for (let index = 0; index < keywords.length; index++) {
                    let keyword = keywords[index];
                    htmlOutput[index] = `<a class="btn p-0 ml-2 popular-keyword text-${fontColor[index] ?? 'success'}" style="font-size: ${fontSize[index]}px !important" data-count="${keyword.jumlah}"> ${keyword.keyword}</a>`;
                }
                popular.html(htmlOutput.sort(() => Math.random() - 0.5).join(""));
                initPencarianPopular();
            } else {
                popular.append('Keyword populer tidak ditemukan');
            }
        }

        function getPopularKeywordLaporan() {
            let rowTrendingKeyword = $('#trending-keyword');
            let wrapperPopular = $('#popular-keyword');

            wrapperPopular.html(preloader);
            flagRegionSelected = false;
            axios.get(route('popular-keyword-dashboard'), {
                params: (Object.keys(SEARCH_STATE.data).length === 0 && SEARCH_STATE.data.constructor === Object) ? {} : SEARCH_STATE.data
            }).then(function (response) {
                wrapperPopular.html("");
                rowTrendingKeyword.find('.card-title:first').html('Trending Keyword Populer Citizen ' + (keyword ?? 'Hari ini'));
                generateKeywordPopularList(response.data);
            }).catch(function (error) {
                console.log(error);
            })
        }

        function placeWordsOnMap() {
            var htmlOutput = [];
            let fontSize = [36, 30, 30, 30, 24, 24, 24, 20, 20, 20];
            let fontColor = ['danger', 'primary', 'primary', 'primary', 'warning', 'warning', 'warning', 'success', 'success', 'success'];
            for (var wordsI = 0; wordsI < words.length; wordsI++) {
                var word = words[wordsI];
                var randomInt = randomIntFromInterval(1, 10);
                htmlOutput[wordsI] = '<a class="word text-' + (fontColor[wordsI] ?? 'success') + '" href="' + word.url + '" style="font-size: ' + fontSize[wordsI] + 'px" target="_blank" data-count="' +
                    randomInt +
                    '">' +
                    word.name +
                    "</a>";
            }
            $("#social-media-trend").html(htmlOutput.sort(() => Math.random() - 0.5).join(""));
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
