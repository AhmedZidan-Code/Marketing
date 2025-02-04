<form id="form" enctype="multipart/form-data" method="POST" action="{{ route('purchases.update', $row->id) }}">
    @csrf
    @method('PUT')
    <div class="row my-4 g-4">

        <div class="d-flex flex-column mb-7 fv-row col-sm-3">
            <!--begin::Label-->
            <label for="purchases_number" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> رقم الطلب</span>
            </label>
            <!--end::Label-->
            <input id="purchases_number" disabled required type="text" class="form-control form-control-solid"
                name="purchases_number" value="{{ $row->purchases_number }}" />
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-3">
            <!--begin::Label-->
            <label for="purchases_date" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> تاريخ الطلب</span>
            </label>
            <!--end::Label-->
            <input id="purchases_date" required type="date" class="form-control form-control-solid"
                name="purchases_date" value="{{ $row->purchases_date }}" />
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-3">
            <!--begin::Label-->
            <label for="pay_method" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> طريقة الشراء </span>
            </label>
            <select id='pay_method' name="pay_method" class="form-control">
                <option selected disabled>اختر طريقة الشراء</option>
                <option @if ($row->pay_method == 'cash') selected @endif value="cash">كاش</option>
                <option @if ($row->pay_method == 'debit') selected @endif value="debit">اجل</option>

            </select>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-3">
            <!--begin::Label-->
            <label for="storage_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> المخزن</span>
            </label>
            <select id='storage_id' name="storage_id" style='width: 200px;'>
                <option value="{{ $row->storage_id }}">{{ $row->storage->title ?? '' }}</option>
            </select>
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-3">
            <!--begin::Label-->
            <label for="supplier_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> المورد</span>
            </label>
            <select id='supplier_id' name="supplier_id" style='width: 200px;'>
                <option value="{{ $row->supplier_id }}">{{ $row->supplier->name ?? '' }}</option>
            </select>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-3">
            <!--begin::Label-->
            <label for="fatora_number" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> رقم الفاتورة</span>
            </label>
            <!--end::Label-->
            <input id="fatora_number" required type="text" class="form-control form-control-solid"
                name="fatora_number" value="{{ $row->fatora_number }}" />
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-3">
            <!--begin::Label-->
            <label for="supplier_fatora_number" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> رقم فاتورة المورد</span>
            </label>
            <!--end::Label-->
            <input id="supplier_fatora_number" required type="text" class="form-control form-control-solid"
                name="supplier_fatora_number" value="{{ $row->supplier_fatora_number }}" />
        </div>

            <div class="table-responsive">
                <table id="table-details" class="table table-bordered table-striped align-middle text-center">
                    <thead class="bg-grey">
                        <tr>
                            <th>المنتج</th>
                            <th>كود المنتج</th>
                            <th>المقاس</th>
                            <th>تاريخ انتهاء الصلاحية</th>
                            <th>الكمية</th>
                            <th>اللون</th>
                            <th>سعر الشراء</th>
                            <th>بونص</th>
                            <th>قيمة الخصم</th>
                            <th>القيمة الاجمالية</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody id="details-container">
                        @foreach (\App\Models\PurchasesDetails::with('size')->where('purchases_id', $row->id)->get() as $key => $pivot)
                        <tr id="tr-{{ $key }}">
                            <td>
                                <div class="mb-2">
                                    <select class="form-select changeKhamId" data-id="{{ $key }}" name="productive_id[]" id="productive_id-{{ $key }}" style='width: 170px;'>
                                        <option selected value="{{ $pivot->productive_id }}">
                                            {{ $pivot->productive->name ?? '' }}
                                        </option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <input type="text" class="form-control text-center" value="{{ $pivot->productive_code }}" 
                                       disabled id="productive_code-{{ $key }}">
                            </td>
                            <td>
                                <select class="form-select" data-id="{{ $key }}" name="size_id[]" id="size_id-{{ $key }}">
                                    <option selected value='{{ $pivot->size_id }}'>{{ $pivot->size->title }}</option>
                                </select>
                            </td>
                            <td>
                                <input type="date" class="form-control text-center" 
                                       value="{{ $pivot->exp_date ?? date('Y-m-d') }}"
                                       id="exp_date-{{ $key }}" name="exp_date[]">
                            </td>
                            <td>
                                <input type="number" class="form-control text-center" data-id="{{ $key }}"
                                       value="{{ $pivot->amount }}" min="1" name="amount[]" 
                                       id="amount-{{ $key }}" onchange="callTotal()" onkeyup="callTotal()">
                            </td>
                            <td>
                                <input type="text" class="form-control navigable text-center" name="color[]"
                                       data-id="{{ $key }}" id="color-{{ $key }}" 
                                       value="{{ $pivot->color }}">
                            </td>
                            <td>
                                <input type="number" class="form-control text-center" data-id="{{ $key }}"
                                       step="0.1" value="{{ $pivot->productive_buy_price }}" min="1"
                                       name="productive_buy_price[]" id="productive_buy_price-{{ $key }}"
                                       onchange="callTotal()" onkeyup="callTotal()">
                            </td>
                            <td>
                                <input type="number" class="form-control text-center" data-id="{{ $key }}"
                                       value="{{ $pivot->bouns }}" name="bouns[]" 
                                       id="bouns-{{ $key }}">
                            </td>
                            <td>
                                <input type="number" class="form-control text-center" data-id="{{ $key }}"
                                       value="{{ $pivot->discount_percentage }}" 
                                       name="discount_percentage[]" id="discount_percentage-{{ $key }}"
                                       onkeyup="callTotal()">
                            </td>
                            <td>
                                <input type="number" class="form-control text-center" disabled 
                                       value="{{ $pivot->total }}" name="total[]"
                                       id="total-{{ $key }}">
                            </td>
                            <td>
                                <button class="btn btn-sm btn-danger delete-sup" data-id="{{ $key }}">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="bg-warning">الاجمالي</th>
                            <th colspan="2" class="bg-secondary text-white" id="total_productive_buy_price">
                                {{ $row->total }}
                            </th>
                            <th class="bg-info text-dark">نسبة الخصم الكلية</th>
                            <th colspan="2" class="bg-secondary">
                                <input type="number" class="form-control bg-transparent text-white" 
                                       id="total_discount" value="{{ $row->total_discount }}"
                                       min="0" max="99" name="total_discount" 
                                       onkeyup="totalAfterDiscount()">
                            </th>
                            <th colspan="2" class="bg-warning">
                                الاجمالي بعد الخصم الكلي
                            </th>
                            <th colspan="2" class="bg-success">
                                <input type="text" class="form-control bg-transparent text-white" 
                                       id="total_after_discount" value="{{ $row->total_after_discount }}"
                                       name="total_discount" disabled>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>

        <div class="d-flex justify-content-end">
            <button id="addNewDetails" class="btn btn-primary">اضافة منتج اخر

            </button>
        </div>


    </div>

    <button form="form" type="submit" id="submit" class="btn btn-primary">
        <span class="indicator-label">اتمام</span>
    </button>

</form>
