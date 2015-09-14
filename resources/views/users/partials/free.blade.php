@if( ! Auth::user()->storage())
    <div class="alert alert-info">
        You are current using the free built-in storage option. Droplets will automatically expire after 30 days. You can upload up to 10 files per Droplet and
        all uploads are limited to 10MB each. To remove limits on your Droplets {!! link_to_route('storage_path', 'add a cloud storage provider') !!} to your account for free.
    </div>
@endif