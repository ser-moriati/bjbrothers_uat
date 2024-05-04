
@if (count($list_data)==0)
    <tr>
        <td colspan="100%">
            <div class="tab-pane" id="confirm-detail">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="text-center">
                            <div class="mb-4 card-title-desc">
                                <i class="bx bx-search-alt text-defult display-4"></i>
                                <h5>Data not found</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>
@endif