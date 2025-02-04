<form id="form" enctype="multipart/form-data" method="POST" action="{{ route('purchases.store') }}">
    @csrf
    <div class="row my-4 g-4">

        <div class="d-flex flex-column mb-7 fv-row col-sm-3">
            <!--begin::Label-->
            <label for="purchases_number" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> رقم الطلب</span>
            </label>
            <!--end::Label-->
            <input id="purchases_number" disabled required type="text" class="form-control form-control-solid"
                name="purchases_number" value="{{ $count + 1 }}" />
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-3">
            <!--begin::Label-->
            <label for="purchases_date" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> تاريخ الطلب</span>
            </label>
            <!--end::Label-->
            <input id="purchases_date" required type="date" class="form-control form-control-solid"
                name="purchases_date" value="{{ date('Y-m-d') }}" />
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-3">
            <!--begin::Label-->
            <label for="pay_method" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> طريقة الشراء </span>
            </label>
            <select id='pay_method' name="pay_method" class="form-control">
                <option selected disabled>اختر طريقة الشراء</option>
                <option value="cash">كاش</option>
                <option value="debit">اجل</option>

            </select>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-3">
            <!--begin::Label-->
            <label for="storage_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> المخزن</span>
            </label>
            <select id='storage_id' name="storage_id" style='width: 200px;'>
                <option selected disabled>- ابحث عن المخزن</option>
            </select>
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-3">
            <!--begin::Label-->
            <label for="supplier_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> المورد</span>
            </label>
            <select id='supplier_id' name="supplier_id" style='width: 200px;'>
                <option selected disabled>- ابحث عن الموردين</option>
            </select>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-3">
            <!--begin::Label-->
            <label for="fatora_number" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> رقم الفاتورة</span>
            </label>
            <!--end::Label-->
            <input id="fatora_number" required type="text" class="form-control form-control-solid"
                name="fatora_number" value="" />
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-3">
            <!--begin::Label-->
            <label for="supplier_fatora_number" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> رقم فاتورة المورد</span>
            </label>
            <!--end::Label-->
            <input id="supplier_fatora_number" required type="text" class="form-control form-control-solid"
                name="supplier_fatora_number" value="" />
        </div>

        <div class="table-responsive">
            <table id="table-details" class="table table-bordered table-striped align-middle">
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
                    <tr id="tr-1">
                        <td>
                            <select class="form-select changeKhamId" data-id="1" name="productive_id[]"
                                id="productive_id" style='width: 170px;'>
                                <option selected disabled value="0">- ابحث عن المنتج -</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control" disabled id="productive_code-1">
                        </td>
                        <td>
                            <select class="form-select" data-id="1" name="size_id[]" id="size_id-1"
                                style="width: 170px;">
                                <option selected disabled value="0">- ابحث عن المقاس -</option>
                            </select>
                        </td>
                        <td>
                            <input type="date" class="form-control date-input" value="" id="exp_date"
                                name="exp_date[]">
                        </td>
                        <td>
                            <input type="number" class="form-control navigable" data-id="1" value="1"
                                min="1" name="amount[]" id="amount-1" onchange="callTotal()"
                                onkeyup="callTotal()">
                        </td>
                        <td>
                            <input data-id="1" class="form-control navigable" type="text" name="color[]"
                                id="color-1">
                        </td>
                        <td>
                            <input type="number" class="form-control navigable" data-id="1" step="0.1"
                                value="1" min="1" name="productive_buy_price[]"
                                id="productive_buy_price-1" onchange="callTotal()" onkeyup="callTotal()">
                        </td>
                        <td>
                            <input type="number" class="form-control navigable" value="0" min="0"
                                name="bouns[]" id="bouns-1">
                        </td>
                        <td>
                            <input type="number" class="form-control navigable" value="0" min="0"
                                name="discount_percentage[]" id="discount_percentage-1" onkeyup="callTotal()">
                        </td>
                        <td>
                            <input type="number" class="form-control" disabled value="1" min="1"
                                name="total[]" id="total-1">
                        </td>
                        <td>
                            <button class="btn btn-danger btn-sm btn-delete" data-id="1">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2" class="footer-highlight-1 text-center">الاجمالي</th>
                        <th colspan="2" id="total_productive_buy_price" class="footer-highlight-2 text-center">1
                        </th>
                        <th class="footer-highlight-3 text-center">نسبة الخصم الكلية</th>
                        <th colspan="2" class="footer-highlight-2 text-center">
                            <input type="number" class="form-control bg-transparent text-white" id="total_discount"
                                value="0" min="0" max="99" name="total_discount"
                                onkeyup="totalAfterDiscount()">
                        </th>
                        <th colspan="2" class="footer-highlight-1 text-center">الاجمالي بعد الخصم الكلي</th>
                        <th class="footer-highlight-4 text-center">
                            <input type="text" class="form-control bg-transparent text-white"
                                id="total_after_discount" disabled>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="d-flex justify-content-end">
            <button id="addNewDetails" class="btn btn-primary navigable">اضافة منتج اخر

            </button>
        </div>


    </div>

    <button form="form" type="submit" id="submit" class="btn btn-primary">
        <span class="indicator-label">اتمام</span>
    </button>

</form>
