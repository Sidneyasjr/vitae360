<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('tax_id', 14)->unique(); // CNPJ
            $table->string('company_name'); // Razão Social
            $table->string('trade_name'); // Nome Fantasia
            $table->string('contact_person'); // Contato de Relacionamento
            $table->string('position'); // Cargo
            $table->string('phone'); // Telefone
            $table->string('phone2')->nullable(); // Telefone 2
            $table->string('contact_email'); // E-mail de Relacionamento
            $table->string('billing_email')->nullable(); // E-mail Faturamento
            $table->string('zip_code', 8); // CEP
            $table->string('address'); // Endereço
            $table->string('number'); // Número
            $table->string('neighborhood'); // Bairro
            $table->string('state', 2); // Estado
            $table->string('city'); // Cidade
            $table->string('lead'); // Lead
            $table->string('interest'); // Interesse
            $table->string('segment'); // Segmento
            $table->string('legal_representative_name')->nullable(); // Nome Representante Legal
            $table->string('legal_representative_tax_id', 11)->nullable(); // CPF Representante Legal
            $table->string('legal_representative_email')->nullable(); // E-mail Representante Legal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
