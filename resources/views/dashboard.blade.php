<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container py-4">
        <h4>Hi there! This is the BankApp. Using the upper menu you can:</h4>
        <br/>
        <ul class="list-group">
            <li class="list-group-item">Manage the Branches (and its customers with their balances) at "<b>Branches</b>"</li>
            <li class="list-group-item">See the transfers's historic and create a new transfer at "<b>Transfers</b>"</li>
            <li class="list-group-item">See some branch's reports</li>
        </ul>
    </div>
</x-app-layout>
