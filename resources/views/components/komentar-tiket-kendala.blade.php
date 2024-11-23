<div class="modal fade" id="modal-komentar" tabindex="-1"
     aria-labelledby="Komentar Tiket Kendala" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Berita</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="komentar" style="max-height: 70vh; overflow-y: auto; overflow-x: hidden">
                </div>
                <hr>
                <form action="{{ route('surat-izin-operasional.comments.store') }}" method="POST" id="comment-store">
                    @csrf
                    <input type="hidden" name="ticket_id">
                    <textarea class="form-control" name="comment" id="comment" rows="3"
                              placeholder="Tulis komentar di sini"></textarea>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary mt-2">Kirim Komentar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        function renderEmptyComment() {
            $('#komentar').append(`
                <div class="card shadow-none border">
                    <div class="card-body">
                        <h5 class="card-title text-muted">Belum ada komentar</h5>
                    </div>
                </div>
            `);
        }
        
        function clearComment() {
            $('#komentar').empty();
        }

        function clearComposeComment() {
            $('#comment').val('');
        }

        function renderShimmer() {
            clearComment();
            $('#komentar').append(`
                <div class="card shadow-none shimmer">
                    <div class="card-body">
                        <div class="lines-title shine d-block"></div>
                        <div class="lines col-3 shine d-block"></div>
                        <div class="lines col-4 shine d-block"></div>
                        <div class="lines shine d-block"></div>
                        <div class="lines shine d-block"></div>
                    </div>
                </div>
            `);
        }

        function clearShimmer() {
            $('#komentar .shimmer').remove();
        }

        function renderComments(comments) {
            comments?.forEach((comment, keys) => {
                console.log(comment.comment)
                $('#komentar').append(`
                    <div class="px-2 pt-2">
                        <div class="d-flex justify-content-between">
                            <p class="card-title"><b>${comment.user.roles[0].alias}</b></p>
                            <small class="col-3 text-muted text-right">${
                                (new Date(comment.created_at)).toLocaleString('id-ID', {
                                    month : 'long',
                                    day   : 'numeric',
                                    year  : 'numeric',
                                    hour  : 'numeric',
                                    minute: 'numeric'
                                })
                            }</small>
                        </div>
                        <p class="card-text">${(comment.comment).replace(/(?:\r\n|\r|\n)/g, '<br>')}</p>
                    </div>
                `.concat(keys === comments.length - 1 ? '' : '<hr>'));
            });

            clearShimmer();
        }

        $('#modal-komentar').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            const id = button.data('id');
            const modal = $(this);

            modal.find('input[name="ticket_id"]').val(id);

            $.ajax({
                url: route('surat-izin-operasional.comments.show', id),
                type: "GET",
                success: function (data) {
                    if ((data.comments).length === 0) {
                        clearShimmer();
                        renderEmptyComment()
                        return;
                    }
                    
                    modal.find('.modal-title').text(`Komentar Tiket Kendala ${data.id_izin}`)
                    renderComments(data.comments);
                },
                error: function (error) {
                    swalError(error);
                },
                beforeSend: function () {
                    renderShimmer();
                }
            });
        });

        $('#comment-store').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: route('surat-izin-operasional.comments.store'),
                type: "POST",
                data: $(this).serialize(),
                success: function (data) {
                    clearComment();
                    renderComments(data.comments);
                },
                error: function (error) {
                    swalError(error);
                },
                beforeSend: function () {
                    renderShimmer();
                }
            });

            clearComposeComment();
        });


        $('#modal-komentar').on('hidden.bs.modal', function (e) {
            clearComment();
            clearComposeComment();
        });
    </script>
@endpush