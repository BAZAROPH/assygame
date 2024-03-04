<div id="flash-overlay-modal" class="modal fade {{ isset($modalClass) ? $modalClass : '' }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close m-0 p-0" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h4 class="modal-title w-100 text-center">{{ $title }}</h4>
            </div>

            <div class="modal-body">
                <p class="text-center alert
                alert-{{ $message['level'] }}
                {{ $message['important'] ? 'alert-important' : '' }}"
                role="alert">{!! $body !!}</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
