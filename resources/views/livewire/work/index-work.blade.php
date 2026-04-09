<div class="row g-3">
    <x-work-column :works="$works" priority="3" color="danger" label="Urgent" />
    <x-work-column :works="$works" priority="2" color="warning" label="High" />
    <x-work-column :works="$works" priority="1" color="primary" label="Medium" />
    <x-work-column :works="$works" priority="0" color="success" label="Low" />
</div>
