<div class="modal fade" id="questionUraian" tabindex="-1" aria-hidden="true"
     aria-labelledby="questionUraianLabel" style="background-color: #63616188">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="questionUraianLabel"></h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="input-5w1h" id="label-5w1h" class="form-label"></label>
                    <textarea name="input-5w1h" id="input-5w1h" class="form-control"
                              rows="6"></textarea>
                </div>
                <div class="d-flex justify-content-end align-items-center mt-3">
                    <button class="btn btn-primary" onclick="uraianInformasi.step()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    class ComposeText5w1h {
        constructor(target) {
            this.elTitle = document.querySelector('#questionUraianLabel')
            this.elInput = document.querySelector('#input-5w1h')
            this.elLabel = document.querySelector('#label-5w1h')
            this.modalQuestionUraian = document.querySelector('#questionUraian')
            this.target = target
            this.answer = {}
            this.questionIndex = 0
            this.question = [
                {
                    questionType: 'what',
                    title: 'Apa',
                    label: 'Apa Informasinya?'
                },
                {
                    questionType: 'when',
                    title: 'Kapan',
                    label: 'Kapan mendapatkan informasi tersebut/kapan kejadian tersebut berlangsung?'
                },
                {
                    questionType: 'where',
                    title: 'Di mana',
                    label: 'Di mana mendapatkan informasi tersebut/di mana kejadian tersebut berlangsung?'
                },
                {
                    questionType: 'who',
                    title: 'Siapa',
                    label: 'Siapa sumber informan dari kejadian tersebut/siapa saja pihak yang terlibat pada kejadian tersebut?'
                // },
                // {
                //     questionType: 'why',
                //     title: 'Mengapa',
                //     label: 'Mengapa kejadian tersebut bisa terjadi?'
                // },
                // {
                //     questionType: 'how',
                //     title: 'Bagaimana',
                //     label: 'Bagaimana cerita detail tentang kejadian/informasi tersebut?'
                }
            ]
        }
        showModal = () => {
            this.modalQuestionUraian.classList.add('show')
            this.modalQuestionUraian.style.display = 'block'
        }
        hideModal = () => {
            this.modalQuestionUraian.classList.remove('show')
            this.modalQuestionUraian.style.display = 'none'
        }
        saveAnswer = (section, value) => {
            this.answer[this.question[this.questionIndex].questionType] = this.elInput.value
        }
        applyQuestion = () => {
            this.elTitle.innerText = this.question[this.questionIndex].title
            this.elLabel.innerText = this.question[this.questionIndex].label
            this.elInput.value = ''
        }
        composeUraian = () => {
            this.target.value = this.answer.when + ', saya mendapatkan informasi tentang '
                + this.answer.what + ', informasi tersebut saya dapatkan dari '
                + this.answer.who + ' di ' + this.answer.where
        }
        step = () => {
            this.showModal()
            this.applyQuestion()
            this.step = this.nextQuestion
        }
        nextQuestion = () => {
            if ((this.questionIndex + 1) < this.question.length) {
                if (this.elInput.value.length) {
                    this.saveAnswer()
                    this.questionIndex += 1
                    this.applyQuestion()
                } else {
                    this.applyQuestion()
                    swalWarning('harap mengisi detail laporan')
                }
            } else {
                this.saveAnswer()
                this.composeUraian()
                this.hideModal()
            }
        }
    }
</script>