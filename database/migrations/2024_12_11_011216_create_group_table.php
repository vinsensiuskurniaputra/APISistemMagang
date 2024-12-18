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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lecturer_id');
            $table->string('title');
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
            $table->timestamps();

            $table->foreign('lecturer_id')->references('id')->on('lecturers')->onDelete('cascade');
        });

        Schema::create('group_student', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('student_id');
            $table->timestamps();

            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->unique(['group_id', 'student_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_student');
        Schema::dropIfExists('groups');
    }
};
