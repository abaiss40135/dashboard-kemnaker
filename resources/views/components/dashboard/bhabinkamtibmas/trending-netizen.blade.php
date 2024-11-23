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
<div class="col-md-6 mt-3">
    <div class="card">
        <div class="header card-header card-title">
            Trending Keyword Populer Citizen Hari Ini
        </div>
        <div class="card-body card-popular-keyword">
            <div id="popular-keyword" class="w-100 text-center"></div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        // Script fetch trending twitter
        var words = [];

        // A $( document ).ready() block.
        $(document).ready(function () {
            getPopularKeywordLaporan();
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
