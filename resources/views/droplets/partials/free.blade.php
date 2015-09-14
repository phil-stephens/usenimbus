@if( ! $droplet->storage_id)
    <div class="alert alert-info">
        This Droplet is using the free built-in storage option and will automatically expire on {{ $droplet->created_at->addDays(30)->format('l jS F, Y') }}. You can upload up to 10 files and
        all uploads are limited to 10MB each.
        @if( ! Auth::user()->storage())
        To remove limits on your Droplets {!! link_to_route('storage_path', 'add a cloud storage provider') !!} to your account for free.
        @endif
    </div>
@endif