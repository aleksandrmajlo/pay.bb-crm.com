<?php

namespace App\Services;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Lang;

class LanguageService
{
    public static function updateTagsTable()
    {
        $languages = Lang::all();
        foreach ($languages as $lang) {
            if ($lang->slug == 'en') continue;

            /*
            $columnName = 'name_' . $lang->slug;
            if (!Schema::hasColumn('tags', $columnName)) {
                Schema::table('tags', function (Blueprint $table) use ($columnName) {
                    $table->string($columnName)->nullable()->after('updated_at');
                });
            }
            */
            $questionColumn = 'question_' . $lang->slug;
            $answerColumn = 'answer_' . $lang->slug;
            if (!Schema::hasColumn('faqs', $questionColumn)) {
                Schema::table('faqs', function (Blueprint $table) use ($questionColumn) {
                    $table->string($questionColumn)->nullable()->after('updated_at');
                });
            }
            if (!Schema::hasColumn('faqs', $answerColumn)) {
                Schema::table('faqs', function (Blueprint $table) use ($answerColumn) {
                    $table->text($answerColumn)->nullable()->after('updated_at');
                });
            }
        }
    }

    public static function deleteLanguageColumn($slug)
    {
        /*
        $columnName = 'name_' . $slug;
        if (Schema::hasColumn('tags', $columnName)) {
            Schema::table('tags', function (Blueprint $table) use ($columnName) {
                $table->dropColumn($columnName);
            });
        }
        */
        $questionColumn = 'question_' . $slug;
        $answerColumn = 'answer_' . $slug;

        if (Schema::hasColumn('faqs', $questionColumn)) {
            Schema::table('faqs', function (Blueprint $table) use ($questionColumn) {
                $table->dropColumn($questionColumn);
            });
        }
        if (Schema::hasColumn('faqs', $answerColumn)) {
            Schema::table('faqs', function (Blueprint $table) use ($answerColumn) {
                $table->dropColumn($answerColumn);
            });
        }

    }

}

// Пример использования:
// LanguageService::updateTagsTable();
// LanguageService::deleteLanguageColumn('uk');
