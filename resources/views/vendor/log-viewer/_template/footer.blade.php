<footer class="main-footer">
    <div class="container">
        <p class="text-muted pull-left">
            {{ trans('message.log_viewer') }} <span class="label label-info">{{ trans('message.version') }} {{ log_viewer()->version() }}</span>
        </p>
        <p class="text-muted pull-right">
            {{ trans('message.created_with') }} <i class="fa fa-heart"></i> {{ trans('message.by_arcanedev') }} <sup>&copy;</sup>
        </p>
    </div>
</footer>
