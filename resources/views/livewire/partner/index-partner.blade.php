<!-- partner-component.blade.php -->

<div class="row">
    <!-- Form for creating/updating partner -->
    <div class="col-md-3">
        <form wire:submit.prevent="savePartner">
        <div class="row g-2">
            <h5>Update or create partner</h5>
            <div class="col-12">
                <input wire:model="partner.name" type="text" class="form-control" placeholder="Name">
                @error('partner.name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="col-12">
                <input wire:model="partner.email" type="email" class="form-control" placeholder="E-mail">
                @error('partner.email') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i> Save</a>
            </div>
        </div>
        </form>
    </div>

    <!-- Display existing partners in a table -->
    <div class="col-md-9">
        <h5>List of partners</h5>
        <table class="table table-sm table-striped">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col" class="text-center">Soft Del. Loans</th>
                    <th scope="col" class="text-center">Hard Del. Loans</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($partners as $partner)
                    <tr>
                        <td>{{ $partner->name }}</td>
                        <td>{{ $partner->email }}</td>
                        <td class="text-center">
                            <a 
                                href=""
                                wire:click.prevent="softDeleteAllPartnerLoans({{$partner}})" class="text-danger-emphasis"
                                wire:confirm="Are you sure you want to soft delete all of partner loans?"
                            ><i class="bi bi-eraser"></i></a>
                        </td>
                        <td class="text-center">
                            <a 
                                href=""
                                wire:click.prevent="forceDeleteAllPartnerLoans({{$partner}})" class="text-danger-emphasis"
                                wire:confirm="Are you sure you want to hard delete all of partner loans?"
                            ><i class="bi bi-x-octagon"></i></a>
                        </td>
                        <td>
                            <a href="" wire:click.prevent="editPartner({{ $partner->id }})" class="text-secondary"><i class="bi bi-pencil"></i></button>
                            <a href="" wire:click.prevent="deletePartner({{ $partner->id }})" class="text-secondary"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
