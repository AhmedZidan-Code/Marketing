<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{ route('unites.update', $row->id) }}">
    @csrf
    @method('PUT')
    <div class="row g-4">


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="title" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">الاسم</span>
            </label>
            <!--end::Label-->
            <input id="title" required type="text" class="form-control form-control-solid" name="title"
                value="{{ $row->title }}" />
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="branch_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> الفرع</span>
            </label>

            <select id="role_id" name="branch_id" class="form-control">
                <option selected disabled>اختر الفرع</option>
                @foreach ($branches as $branch)
                    <option value="{{ $branch->id }}" {{ $row->branch_id == $branch->id ? 'selected' : '' }}>
                        {{ $branch->title }}</option>
                @endforeach
            </select>

        </div>



    </div>
</form>
