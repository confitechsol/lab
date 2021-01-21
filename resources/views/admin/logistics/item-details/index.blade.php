@extends('admin.logistics.base')
@section('logistics-title', 'Purchase / Stock Transfer Advice - Item Details')
@section('logistics')


    <div class="card">
        <div class="card-block">
            <div class="row">
                <div class="col-sm-6">
                    <p>Lab - SMS Jaipur</p>
                    <p class="mb-0">Requisition No. :PQR/SMS/JAIPUR/19-20/00001</p>
                </div>
                <div class="col-sm-6">
                    <p>Purchase Advice No. : PAD/SMS/JAIPUR/19-20/00001</p>
                    <p class="mb-0">Purchase Advice Date : 11/05/2019</p>
                </div>
            </div>
        </div>
    </div>

    <form action="#">

        <div class="card">
            <div class="card-block p-2">

                <table class="table table-striped table-sm">

                    <thead>
                    <tr>
                        <th>
                            <select class="form-control">
                                <option value="#">Item Type</option>
                                <option value="consumable">Consumable</option>
                                <option value="non_consumable">Non Consumable</option>
                                <option value="others">Others</option>
                            </select>
                        </th>
                        <th width="90">
                            <input type="text" class="form-control" name="item-code" id="item-code" placeholder="Item Code">
                        </th>
                        <th class="text-center">Nomenclature</th>
                        <th>Pack Size</th>
                        <th>UOM</th>
                        <th>
                            <div class="shorting">
                                Reorder Level
                                <a href="#" class="up"><i class="fas fa-sort-up"></i></a>
                                <a href="#" class="down"><i class="fas fa-sort-down"></i></a>
                            </div>
                        </th>
                        <th>
                            <div class="shorting">
                                Current Stock
                                <a href="#" class="up"><i class="fas fa-sort-up"></i></a>
                                <a href="#" class="down"><i class="fas fa-sort-down"></i></a>
                            </div>
                        </th>
                        <th>Stock to be Transferred</th>
                        <th>Effective Current Stock</th>
                        <th>Last 3 Months Consumption</th>
                        <th>Require Quantity</th>
                        <th width="65">Advice Quentity</th>
                    </tr>
                    </thead>

                    <tbody>

                    <tr>
                        <td>C</td>
                        <td>134678</td>
                        <td><span class="nomenclature" title="Lorem ipsum dolor sit amet, consectetur adipisicing elit">Lorem ipsum dolor sit amet, consectetur adipisicing elit</span> </td>
                        <td>6</td>
                        <td>Box</td>
                        <td>30</td>
                        <td>46</td>
                        <td>16</td>
                        <td>30</td>
                        <td>0</td>
                        <td>25</td>
                        <td><input type="number" value="0" class="form-control"/></td>
                    </tr>

                    <tr>
                        <td>C</td>
                        <td>134678</td>
                        <td><span class="nomenclature" title="Lorem ipsum dolor sit amet, consectetur adipisicing elit">Lorem ipsum dolor sit amet, consectetur adipisicing elit</span> </td>
                        <td>6</td>
                        <td>Box</td>
                        <td>30</td>
                        <td>46</td>
                        <td>16</td>
                        <td>30</td>
                        <td>0</td>
                        <td>25</td>
                        <td><input type="number" value="0" class="form-control"/></td>
                    </tr>

                    <tr>
                        <td>C</td>
                        <td>134678</td>
                        <td><span class="nomenclature" title="Lorem ipsum dolor sit amet, consectetur adipisicing elit">Lorem ipsum dolor sit amet, consectetur adipisicing elit</span> </td>
                        <td>6</td>
                        <td>Box</td>
                        <td>30</td>
                        <td>46</td>
                        <td>16</td>
                        <td>30</td>
                        <td>0</td>
                        <td>25</td>
                        <td><input type="number" value="0" class="form-control"/></td>
                    </tr>

                    </tbody>

                </table>

            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>

    </form>



@endsection