@extends('admin.layout.app')

@php( $is_central_lab = this_lab() ? false : true )

@section('primary-nav')
    <li class="nav-item heading">Logistics</li>

    <li class="nav-item nav-group-item nav-group-item-first">
        <a class="nav-button {{ is_sub_route('logistics.dashboard') ? 'active' : '' }}"
           href="{{ route('logistics.dashboard') }}">
            <i class="far fa-chart-bar"></i> Dashboard
        </a>
    </li>

    @if( !$is_central_lab )
    <li class="nav-item nav-group-item">
        <a class="nav-button {{ is_sub_route('logistics.item.opening-balance') ? 'active' : '' }}"
           href="{{ route('logistics.item.opening-balance') }}">
            <i class="fas fa-box-open"></i> Opening
        </a>
    </li>
    <li class="nav-item nav-group-item">
        <a class="nav-button {{ is_sub_route('logistics.item') ? 'active' : '' }}"
           href="{{ route('logistics.item.index') }}">
            <i class="fas fa-box"></i> Current Stock
        </a>
    </li>
    @endif

    @if( $is_central_lab )
    <li class="nav-item nav-group-item">
        <a class="nav-button {{ is_sub_route('logistics.stock') ? 'active' : '' }}"
           href="{{ route('logistics.stock.index', ['mode' => 'grouped']) }}">
            <i class="fas fa-box"></i> Procurement Advice
        </a>
    </li>
    @endif

    <li class="nav-item nav-group-item">
        <a class="nav-button {{ is_sub_route('logistics.requisition') ? 'active' : '' }}"
           href="{{ route('logistics.requisition.index') }}">
            <i class="fas fa-sync-alt"></i> {{ $is_central_lab ? 'Transfer Advice' : 'Requisition' }}
        </a>
    </li>

    @if( $is_central_lab )
    <li class="nav-item nav-group-item nav-group-item-last">
        <a class="nav-button {{ ( is_sub_route('logistics.advice') AND \App\Model\Logistics\Advice::TYPE_PURCHASE === request()->route('type') ) ? 'active' : '' }}"
           href="{{ route('logistics.advice.purchase.index', \App\Model\Logistics\Advice::TYPE_PURCHASE) }}">
            <i class="fas fa-shipping-fast"></i> Shipment
        </a>
    </li>
    @endif

    @if( !$is_central_lab )
    <li class="nav-item nav-group-item">
        <a class="nav-button {{ ( is_sub_route('logistics.advice') AND \App\Model\Logistics\Advice::TYPE_TRANSFER === request()->route('type') ) ? 'active' : '' }}"
           href="{{ route('logistics.advice.transfer.index', \App\Model\Logistics\Advice::TYPE_TRANSFER) }}">
            <i class="fas fa-dolly"></i> Transfer
        </a>
    </li>
    <li class="nav-item nav-group-item">
        <a class="nav-button {{ is_sub_route('logistics.reeceipt') ? 'active' : '' }}"
           href="{{ route('logistics.receipt.index') }}">
            <i class="fas fa-file-invoice"></i> Receipt
        </a>
    </li>
    <li class="nav-item nav-group-item nav-group-item-last">
        <a class="nav-button {{ is_sub_route('logistics.issue') ? 'active' : '' }}"
           href="{{ route('logistics.issue.stock') }}">
            <i class="fas fa-exclamation-circle"></i> Issue
        </a>
    </li>
    @endif
@endsection

@section('content')
    <style>

        .btn-sm{
            padding: .5rem 1rem;
        }

        .nav-logistics{
            align-items: center;
        }

        .nav-logistics .nav-item{
            height: 36px !important;
            margin-right: 4px;
        }

        .nav-logistics .nav-item.nav-group-item{
            margin-right: 0;
            border-right: rgba(255,255,255,0.8) solid 1px;
        }

        .nav-logistics .nav-item.nav-group-item.nav-group-item-last{
            border-right: none;
        }

        .nav-logistics .nav-item.heading{
            font-size: 1.4rem;
            color: white;
            margin-right: 1rem;
        }

        .nav-logistics .nav-item .nav-button{
            display: block;
            font-size: 14px !important;
            height: 36px !important;
            line-height: 23px !important;
            padding: 7px 18px 9px !important;
            background: rgba(255,255,255, 0.9);
            color: #1E88E5;
        }

        .nav-logistics .nav-item .nav-button:hover{
            background: white;
        }

        .nav-logistics .nav-item .nav-button.active{
            background: #45484d;
            color: white;
        }

        .nav-logistics .nav-item.nav-group-item.nav-group-item-first .nav-button{
            border-radius: 4px 0 0 4px;
        }

        .nav-logistics .nav-item.nav-group-item.nav-group-item-last .nav-button{
            border-radius: 0 4px 4px 0;
        }

         .table thead th{
            padding-bottom: 20px;
            padding-left: 3px;
            padding-right: 3px;
            font-size: 0.65rem ;
            font-weight: bold;
            vertical-align: middle;
         }

         .table tbody td{
            font-size: 0.75rem;
            text-align: center;
            vertical-align: middle;
        }

        .nomenclature{
            max-width: 200px;
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
            display: block;
        }

        .shorting{
            width: 100px;
            position: relative;
        }

        .shorting a{
            position: absolute;
        }

        .shorting .up{
            top: -7px;
            right: 5px;
        }

        .shorting .down{
            right: 5px;
        }

        .form-control{
            padding: 4px 6px !important;
            min-height: 32px !important;
            height: 36px !important;
        }


        .bg-alert{
            background-color: #ffd0b8 !important;
        }

        .bg-exists{
            background-color: #d1ffba !important;
        }

        .logistics-dropdown .fas,
        .logistics-dropdown .far,
        .logistics-dropdown .fab{
            width: 20px;
            text-align: center;
            margin-right: 8px;
        }


        .form-group{
            margin-bottom: 20px;
        }

        .pagination-wrap{
            font-size: 0.9rem;
            display: flex;
            justify-content: space-between;
        }

        .td-valign-top td{
            vertical-align: top !important;
        }

    </style>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row page-titles">
                <div class="col-md-7 align-self-center">
                    <h4 class="text-themecolor m-b-0 m-t-0">@yield('logistics-title')</h4>
                </div>
                <div class="col-md-5 text-right">
                    @yield('secondary-nav')
                </div>
            </div>

            @yield('logistics')

        </div>
    </div>
@endsection


@section('footer')
    <script src="{{ asset('js/logistics.js') }}"></script>
@endsection