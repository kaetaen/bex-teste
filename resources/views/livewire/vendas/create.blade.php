<div>
    <form wire:submit.prevent="registerSail">

        <x-card title="Cadastro de vendas">

            <x-select wire:focus="getProducts" label="Produto" wire:model="selectedProduct" option-label="name"
        option-value="id" :options="$products"  placeholder="Selecione um produto"></x-select>
            @error('selectedProduct') <span class="error text-red-500" >{{ $message }}</span> @enderror
        
            <x-input wire:model.defer="amount" label="Quantidade:" type="number" placeholder="Quantidade" name="price" />
            @error('amount') <span class="error text-red-500" >{{ $message }}</span> @enderror

            <x-button  type="submit" spinner="save" primary label="Comprar" />
        </x-card>

        <x-slot name="footer" class="place-items-end">

            <div>
                <x-button  type="submit" spinner="save" primary label="Salvar" />
            </div>

        </x-slot>

    <form>
</div>