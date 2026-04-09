<div class="row g-3">
    <!-- Form for creating/updating partner -->
    <div class="col-md-3">
        <div class="panel">
            <h5 class="panel-title"><i class="bi bi-people"></i> {{ $partner->id ?? false ? 'Edit' : 'New' }} partner</h5>
            <form wire:submit.prevent="savePartner">
              <div class="row g-2">
                <div class="col-12">
                    <input wire:model="partner.name" type="text" class="form-control" placeholder="Name">
                    @error('partner.name') <span class="text-danger text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="col-12">
                    <input wire:model="partner.email" type="email" class="form-control" placeholder="E-mail">
                    @error('partner.email') <span class="text-danger text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-sm w-100"><i class="bi bi-floppy"></i> Save</button>
                </div>
              </div>
            </form>
        </div>
    </div>

    <!-- Display existing partners -->
    <div class="col-md-9">
        <div class="modern-table">
            <table class="table table-sm mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th class="text-center">Soft Del.</th>
                        <th class="text-center">Hard Del.</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($partners as $partner)
                        <tr>
                            <td class="fw-semibold">{{ $partner->name }}</td>
                            <td class="text-secondary text-sm">{{ $partner->email }}</td>
                            <td class="text-center">
                                <a href=""
                                    wire:click.prevent="softDeleteAllPartnerLoans({{$partner}})"
                                    wire:confirm="Are you sure you want to soft delete all partner loans?"
                                    class="action-btn" style="width:auto;height:auto;color:#e74c3c">
                                    <i class="bi bi-eraser"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a href=""
                                    wire:click.prevent="forceDeleteAllPartnerLoans({{$partner}})"
                                    wire:confirm="Are you sure you want to permanently delete all partner loans?"
                                    class="action-btn" style="width:auto;height:auto;color:#e74c3c">
                                    <i class="bi bi-x-circle"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="" wire:click.prevent="editPartner({{ $partner->id }})" class="action-btn" style="width:auto;height:auto"><i class="bi bi-pencil"></i></a>
                                <a href="" wire:click.prevent="deletePartner({{ $partner->id }})" class="action-btn" style="width:auto;height:auto"><i class="bi bi-trash3"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
