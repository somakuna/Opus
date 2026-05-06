<div>
    <form wire:submit.prevent="update">
        <div class="modern-form">
            <h3 class="form-header"><i class="bi bi-pencil-square"></i> Edit circular</h3>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" wire:model="circular.client" class="form-control @error('circular.client') is-invalid @enderror" placeholder=" ">
                        <label>Client</label>
                    </div>
                    @error('circular.client')<div class="text-danger text-sm mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <select wire:model="circular.type" class="form-select @error('circular.type') is-invalid @enderror">
                            <option value="License">License</option>
                            <option value="Payment">Payment</option>
                            <option value="Administration">Administration</option>
                            <option value="Maintenance">Maintenance</option>
                            <option value="Obligation">Obligation</option>
                            <option value="Rent">Rent</option>
                            <option value="Internal Process">Internal Process</option>
                        </select>
                        <label>Type</label>
                    </div>
                    @error('circular.type')<div class="text-danger text-sm mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <textarea wire:model="circular.description" class="form-control @error('circular.description') is-invalid @enderror" placeholder=" " style="height: 120px"></textarea>
                        <label>Description</label>
                    </div>
                    @error('circular.description')<div class="text-danger text-sm mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" wire:model="start_date" class="form-control @error('start_date') is-invalid @enderror" placeholder=" " inputmode="numeric" maxlength="11">
                        <label>Start date (dd.mm.yyyy.)</label>
                    </div>
                    @error('start_date')<div class="text-danger text-sm mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" wire:model="end_date" class="form-control @error('end_date') is-invalid @enderror" placeholder=" " inputmode="numeric" maxlength="11">
                        <label>End date (dd.mm.yyyy.)</label>
                    </div>
                    @error('end_date')<div class="text-danger text-sm mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <div class="form-floating">
                            <input type="number" wire:model="circular.frequency_value" class="form-control @error('circular.frequency_value') is-invalid @enderror" placeholder=" " min="1">
                            <label>Every</label>
                        </div>
                        <select wire:model="circular.frequency_unit" class="form-select" style="max-width: 120px;">
                            <option value="day">Day(s)</option>
                            <option value="week">Week(s)</option>
                            <option value="month">Month(s)</option>
                            <option value="year">Year(s)</option>
                        </select>
                    </div>
                    @error('circular.frequency_value')<div class="text-danger text-sm mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="number" wire:model="circular.price" class="form-control @error('circular.price') is-invalid @enderror" placeholder=" " step="0.01">
                        <label>Price</label>
                    </div>
                    @error('circular.price')<div class="text-danger text-sm mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <select wire:model="circular.status" class="form-select @error('circular.status') is-invalid @enderror">
                            <option value="active">Active</option>
                            <option value="paused">Paused</option>
                            <option value="ended">Ended</option>
                        </select>
                        <label>Status</label>
                    </div>
                    @error('circular.status')<div class="text-danger text-sm mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="col-12 d-flex justify-content-between align-items-center pt-2">
                    <div class="loading-spinner" wire:loading>
                        <div class="spinner-border" role="status"></div>
                        <span>Saving...</span>
                    </div>
                    <div class="ms-auto">
                        <a href="{{ route('circular.index') }}" class="btn btn-outline-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-lg"></i> Update
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
