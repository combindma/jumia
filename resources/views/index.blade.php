@extends('dashui::layouts.app')
@section('title', 'Jumia')
@section('content')
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <div class="pb-5 border-b border-gray-200">
                <h3 class="text-2xl leading-6 font-medium text-gray-900">
                    Jumia Seller
                </h3>
                <p class="mt-2 max-w-4xl text-sm text-gray-500">Cet outil permet de communiquer avec Jumia Seller Center pour mettre à jour les informations des produits automatiquement.</p>
            </div>
            <div class="mt-6">
                @include('dashui::components.alert')
                <div class="mt-4">
                    <a href="{{ route('jumia::jumia.testApi') }}" class="btn btn--md" target="_blank">Cliquez ici pour tester API</a>
                </div>
                <div class="mt-4">
                    <a href="{{ route('jumia::jumia.exportProducts') }}" class="btn " target="_blank">Exporter les produits pour Jumia</a>
                </div>
                <div class="mt-4">
                    <a href="{{ route('jumia::jumia.getProducts') }}" class="btn " target="_blank">Cliquez ici pour générer le fichier xml des produits</a>
                </div>
                <div class="mt-4">
                    <a href="{{ route('jumia::jumia.getProductsImages') }}" class="btn " target="_blank">Cliquez ici pour générer le fichier xml des images produits</a>
                </div>
                <div class="mt-4">
                    <a href="{{ route('jumia::jumia.syncProducts') }}" class="btn ">Mettre à jour tous les produits sur Jumia</a>
                </div>
                <div class="mt-4">
                    <a href="{{ route('jumia::jumia.syncImages') }}" class="btn ">Mettre à jour tous les images des produits sur Jumia</a>
                </div>
            </div>
        </div>
    </div>
@endsection
