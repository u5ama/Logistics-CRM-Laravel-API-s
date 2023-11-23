<?php

use App\Http\Controllers\Api\Accounts\Quotes\ClientQuotesController;
use App\Http\Controllers\Api\Admin\Asset\AssetDocuments\AssetDocumentsController;
use App\Http\Controllers\Api\Admin\Asset\Assets\AssetController;
use App\Http\Controllers\Api\Admin\Asset\AssetSubcontractor\AssetSubcontractorController;
use App\Http\Controllers\Api\Admin\Asset\AttachmentDocuments\AttachmentDocumentsController;
use App\Http\Controllers\Api\Admin\Asset\Attachments\AttachmentsController;
use App\Http\Controllers\Api\Admin\Asset\Skills\SkillsController;
use App\Http\Controllers\Api\Admin\Asset\Tags\ResourceTagCategoriesController;
use App\Http\Controllers\Api\Admin\Asset\Tags\TagsController;
use App\Http\Controllers\Api\Admin\Auth\AuthController;
use App\Http\Controllers\Api\Admin\Clients\ClientContactsController;
use App\Http\Controllers\Api\Admin\Clients\ClientDocumentsController;
use App\Http\Controllers\Api\Admin\Clients\ClientsController;
use App\Http\Controllers\Api\Admin\Documents\DocumentsController;
use App\Http\Controllers\Api\Admin\DocuSign\DocuSignController;
use App\Http\Controllers\Api\Admin\Drivers\DriversController;
use App\Http\Controllers\Api\Admin\EmailSettings\EmailSettingsController;
use App\Http\Controllers\Api\Admin\Invoicing\AllocatedInvoicesController;
use App\Http\Controllers\Api\Admin\Invoicing\InvoiceController;
use App\Http\Controllers\Api\Admin\Jobs\JobChecklistController;
use App\Http\Controllers\Api\Admin\Jobs\JobsController;
use App\Http\Controllers\Api\Admin\Jobs\JobsDocumentsController;
use App\Http\Controllers\Api\Admin\Quotes\QuotesFooterController;
use App\Http\Controllers\Api\Admin\Quotes\QuotesTermsConditionsController;
use App\Http\Controllers\Api\Admin\Subcontractor\SubcontractorDriversController;
use App\Http\Controllers\Api\Admin\SuperAdmin\DashboardController;
use App\Http\Controllers\Api\Admin\SuperAdmin\UserTagsController;
use App\Http\Controllers\Api\Assignar\AssignarController;
use App\Http\Controllers\Api\Drivers\Jobs\DriverJobsController;
use App\Http\Controllers\Api\Drivers\Jobs\DriverJobsDocumentsController;
use App\Http\Controllers\Api\Admin\MYOB\MYOBController;
use App\Http\Controllers\Api\Admin\Notes\NotessController;
use App\Http\Controllers\Api\Admin\Products\ProductsController;
use App\Http\Controllers\Api\Admin\Quotes\QuoteDocumentsController;
use App\Http\Controllers\Api\Admin\Quotes\QuotesController;
use App\Http\Controllers\Api\Admin\Quotes\QuotesSettingsController;
use App\Http\Controllers\Api\Admin\Roles\PermissionsController;
use App\Http\Controllers\Api\Admin\Roles\RolesController;
use App\Http\Controllers\Api\Admin\Subcontractor\SubcontractorController;
use App\Http\Controllers\Api\Admin\Subcontractor\SubcontractorDocumentsController;
use App\Http\Controllers\Api\Admin\SuperAdmin\AddressesController;
use App\Http\Controllers\Api\Admin\SuperAdmin\UserController;
use App\Http\Controllers\Api\Admin\Suppliers\SupplierContactsController;
use App\Http\Controllers\Api\Admin\Suppliers\SupplierController;
use App\Http\Controllers\Api\Admin\Suppliers\SupplierDocumentsController;
use App\Http\Controllers\Api\Admin\Suppliers\SupplierItemsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Assigners
Route::prefix('assignar')->name('assignar')->group(function() {
   Route::get('getAssets', [AssignarController::class, 'getAssets']);
   Route::get('index', [AssignarController::class, 'index']);
});
Route::middleware(['cors'])->prefix('v1')->name('api.v1.')->group(function(){
    Route::post('login', [AuthController::class,'login'])->name('login');
    Route::post('register', [AuthController::class,'register'])->name('register');
    Route::post('changeNewUserStatus/{id}', [AuthController::class,'changeNewUserStatus'])->name('changeNewUserStatus');
    Route::post('sendPasswordResetLink', [AuthController::class,'forgotPassword'])->name('sendPasswordResetLink');
    Route::post('resetPassword', [AuthController::class,'resetPassword'])->name('resetPassword');

    Route::get('myobRedirect', [MYOBController::class,'redirectUrl'])->name('myobRedirect');
    Route::get('docusign/callback', [DocuSignController::class,'callback'])->name('docusign.callback');
    Route::get('connect-docusign', [DocuSignController::class,'connectDocusign'])->name('connect.docusign');

    Route::post('uploadDocument', [DocuSignController::class,'uploadDocumentToDocuSign'])->name('connect.upload');
    Route::group(['middleware' => ['jwt.verify']], function(){
        //Dashboard
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::group(['middleware' => 'is_admin:superAdmin', 'prefix' => 'superAdmin','as' => 'superAdmin.'], function () {
            //Change Password
            Route::controller(UserController::class)->group(function() {
                Route::post('changePassword', 'change_password')->name('changePassword');;
            });
            //Drivers Module
            Route::controller(DriversController::class)->group(function() {
                Route::get('drivers', 'index')->name('drivers.index');
                Route::get('allDrivers', 'allDrivers')->name('drivers.allDrivers');
            });

            // Users Module
            Route::controller(UserController::class)->group(function(){
                //Users Modules
                Route::get('users', 'index')->name('users.index');
                Route::post('users', 'store')->name('users.store');
                Route::get('users/create', 'create')->name('users.create');
                Route::post('userShow', 'show')->name('users.show');
                Route::post('users/{id}', 'update')->name('users.update');
                Route::delete('users/{id}', 'destroy')->name('users.destroy');
                Route::post('changeStatus/{id}', 'changeStatus')->name('users.status');
                //User Roles
                Route::get('userRoles', 'userRoles')->name('users.userRoles');
                //All Logs and Activities
                Route::get('allLogs', 'allLogs')->name('users.allLogs');
                Route::get('allActivities/{id}', 'allActivities')->name('users.allActivities');

                Route::get('newUsers', 'getAllNewRegisteredUsers')->name('users.newUsers');
                Route::post('newUserShow', 'showNewUser')->name('users.newUserShow');

                Route::post('updateNewUser/{id}', 'updateNewUser')->name('users.updateNewUser');
            });

            //User tags
            Route::controller(UserTagsController::class)->group(function(){
                Route::get('userTags', 'index')->name('userTags.index');
                Route::post('userTags', 'store')->name('userTags.store');
                Route::delete('userTags/{id}', 'destroy')->name('userTags.destroy');
            });

            // User Addresses
            Route::controller(AddressesController::class)->group(function(){
                Route::get('addresses', 'index')->name('addresses.index');
                Route::post('addresses', 'store')->name('addresses.store');
                Route::post('showAddress', 'show')->name('addresses.show');
                Route::post('addresses/{id}', 'update')->name('addresses.update');
                Route::delete('addresses/{id}', 'destroy')->name('addresses.destroy');
            });

            //Roles
            Route::controller(RolesController::class)->group(function(){
                Route::get('roles', 'index')->name('roles.index');
                Route::post('roles', 'store')->name('roles.store');
                Route::post('showRoles', 'show')->name('roles.show');
                Route::post('roles/{id}', 'update')->name('roles.update');
                Route::delete('roles/{id}', 'destroy')->name('roles.destroy');
            });

            //Permissions
            Route::controller(PermissionsController::class)->group(function(){
                Route::get('permissions', 'index')->name('permissions.index');
                Route::post('permissions', 'store')->name('permissions.store');
                Route::post('showPermissions', 'edit')->name('permissions.edit');
                Route::post('permissions/{id}', 'update')->name('permissions.update');
                Route::delete('permissions/{id}', 'destroy')->name('permissions.destroy');
            });

            //Notes
            Route::controller(NotessController::class)->group(function(){
                Route::get('notes', 'index')->name('notes.index');
                Route::post('notes', 'store')->name('notes.store');
                Route::post('showNotes', 'show')->name('notes.show');
                Route::delete('notes/{id}', 'destroy')->name('notes.destroy');
            });

            //Documents
            Route::controller(DocumentsController::class)->group(function(){
                Route::get('documents', 'index')->name('documents.index');
                Route::post('documents', 'store')->name('documents.store');
                Route::post('showDocuments', 'show')->name('documents.show');
                Route::delete('documents/{id}', 'destroy')->name('documents.destroy');
            });

            //Subcontractor
            Route::controller(SubcontractorController::class)->group(function(){
                Route::get('subcontractors', 'index')->name('subcontractors.index');
                Route::post('subcontractors', 'store')->name('subcontractors.store');
                Route::post('showSubcontractor', 'show')->name('subcontractors.show');
                Route::post('subcontractors/{id}', 'update')->name('subcontractors.update');
                Route::delete('subcontractors/{id}', 'destroy')->name('subcontractors.destroy');
            });

            //Subcontractor Drivers
            Route::controller(SubcontractorDriversController::class)->group(function(){
                Route::get('subcontractorDriver', 'index')->name('subcontractorDriver.index');
                Route::post('subcontractorDriver', 'store')->name('subcontractorDriver.store');
                Route::delete('subcontractorDriver/{id}', 'destroy')->name('subcontractorDriver.destroy');
            });

            //Subcontractor Documents
            Route::controller(SubcontractorDocumentsController::class)->group(function(){
                Route::get('subcontractorDocuments', 'index')->name('subcontractorDocuments.index');
                Route::post('subcontractorDocuments', 'store')->name('subcontractorDocuments.store');
                Route::post('showSubcontractorDocuments/{id}', 'show')->name('subcontractorDocuments.show');
                Route::delete('subcontractorDocuments/{id}', 'destroy')->name('subcontractorDocuments.destroy');

                Route::post('changeDocumentStatus/{id}', 'changeDocumentStatus')->name('subcontractorDocuments.changeDocumentStatus');
            });

            //Attachments
            Route::controller(AttachmentsController::class)->group(function(){
                Route::get('attachments', 'index')->name('attachments.index');
                Route::post('attachments', 'store')->name('attachments.store');
                Route::post('showAttachments', 'show')->name('attachments.show');
                Route::post('attachments/{id}', 'update')->name('attachments.update');
                Route::delete('attachments/{id}', 'destroy')->name('attachments.destroy');
            });

            //Attachment Documents
            Route::controller(AttachmentDocumentsController::class)->group(function(){
                Route::get('attachmentDocuments', 'index')->name('attachmentDocuments.index');
                Route::post('attachmentDocuments', 'store')->name('attachmentDocuments.store');
                Route::post('showAttachmentDocuments', 'show')->name('attachmentDocuments.show');
                Route::delete('attachmentDocuments/{id}', 'destroy')->name('attachmentDocuments.destroy');
            });

            //Tags
            Route::controller(TagsController::class)->group(function(){
                Route::get('tags', 'index')->name('tags.index');
                Route::post('tags', 'store')->name('tags.store');
                Route::delete('tags/{id}', 'destroy')->name('tags.destroy');
            });

            //Resource Category
            Route::controller(ResourceTagCategoriesController::class)->group(function(){
                Route::get('resourceCategory', 'index')->name('resourceCategory.index');
                Route::post('resourceCategory', 'store')->name('resourceCategory.store');
                Route::delete('resourceCategory/{id}', 'destroy')->name('resourceCategory.destroy');
            });

            //Skills
            Route::controller(SkillsController::class)->group(function(){
                Route::get('skills', 'index')->name('skills.index');
                Route::post('skills', 'store')->name('skills.store');
                Route::delete('skills/{id}', 'destroy')->name('skills.destroy');
            });

            //Assets
            Route::controller(AssetController::class)->group(function(){
                Route::get('assets', 'index')->name('assets.index');
                Route::post('assets', 'store')->name('assets.store');
                Route::post('showAsset', 'show')->name('assets.show');
                Route::post('assets/{id}', 'update')->name('assets.update');
                Route::delete('assets/{id}', 'destroy')->name('assets.destroy');
            });

            //Asset Documents
            Route::controller(AssetDocumentsController::class)->group(function(){
                Route::get('assetDocuments', 'index')->name('assetDocuments.index');
                Route::post('assetDocuments', 'store')->name('assetDocuments.store');
                Route::post('showAssetDocuments', 'show')->name('assetDocuments.show');
                Route::delete('assetDocuments/{id}', 'destroy')->name('assetDocuments.destroy');
            });

            //Asset Subcontractor SMS
            Route::controller(AssetDocumentsController::class)->group(function(){
                Route::get('sendSMS', 'index')->name('sendSMS.index');
                Route::post('sendSMS', 'store')->name('sendSMS.store');
                Route::post('sendSMS', 'show')->name('sendSMS.show');
                Route::delete('sendSMS/{id}', 'destroy')->name('sendSMS.destroy');
            });

            //Asset Subcontractor
            Route::controller(AssetSubcontractorController::class)->group(function(){
                Route::get('assetSubcontractor', 'index')->name('assetSubcontractor.index');
                Route::post('assetSubcontractor', 'store')->name('assetSubcontractor.store');
                Route::post('showAssetSubcontractor', 'show')->name('assetSubcontractor.show');
                Route::post('assetSubcontractor/{id}', 'update')->name('assetSubcontractor.update');
                Route::delete('assetSubcontractor/{id}', 'destroy')->name('assetSubcontractor.destroy');
            });

            //MYOB
            Route::controller(MYOBController::class)->group(function(){
                Route::get('getSettings', 'getConnectionStatus')->name('getSettings.index');
                Route::delete('getSettings/{id}', 'destroy')->name('getSettings.destroy');
            });

            //DOCUSIGN
            Route::controller(DocuSignController::class)->group(function(){
                Route::get('getDocusignSettings', 'getDocusignSettings')->name('getDocusignSettings');
                Route::get('sign-document', 'signDocument')->name('docusign.sign');
                Route::delete('getDocusignSettings/{id}', 'destroy')->name('docusign.destroy');
            });

            //Supplier
            Route::controller(SupplierController::class)->group(function(){
                Route::get('supplier', 'index')->name('supplier.index');
                Route::post('supplier', 'store')->name('supplier.store');
                Route::post('showSupplier', 'show')->name('supplier.show');
                Route::post('supplier/{id}', 'update')->name('supplier.update');
                Route::delete('supplier/{id}', 'destroy')->name('supplier.destroy');
            });

            //SupplierContact
            Route::controller(SupplierContactsController::class)->group(function(){
                Route::get('supplierContact', 'index')->name('supplierContact.index');
                Route::post('supplierContact', 'store')->name('supplierContact.store');
                Route::post('showSupplierContact', 'show')->name('supplierContact.show');
                Route::post('supplierContact/{id}', 'update')->name('supplierContact.update');
                Route::delete('supplierContact/{id}', 'destroy')->name('supplierContact.destroy');
            });

            //SupplierItems
            Route::controller(SupplierItemsController::class)->group(function(){
                Route::get('supplierItem', 'index')->name('supplierItem.index');
                Route::post('supplierItem', 'store')->name('supplierItem.store');
                Route::post('showSupplierItem', 'show')->name('supplierItem.show');
                Route::post('supplierItem/{id}', 'update')->name('supplierItem.update');
                Route::delete('supplierItem/{id}', 'destroy')->name('supplierItem.destroy');
            });

            //SupplierDocuments
            Route::controller(SupplierDocumentsController::class)->group(function(){
                Route::get('supplierDocument', 'index')->name('supplierDocument.index');
                Route::post('supplierDocument', 'store')->name('supplierDocument.store');
                Route::post('showSupplierDocument', 'show')->name('supplierDocument.show');
                Route::post('supplierDocument/{id}', 'update')->name('supplierDocument.update');
                Route::delete('supplierDocument/{id}', 'destroy')->name('supplierDocument.destroy');
            });

            //Products
            Route::controller(ProductsController::class)->group(function(){
                Route::get('products', 'index')->name('products.index');
                Route::post('products', 'store')->name('products.store');
                Route::post('showProduct', 'show')->name('products.show');
                Route::post('products/{id}', 'update')->name('products.update');
                Route::delete('products/{id}', 'destroy')->name('products.destroy');
            });

            //Clients
            Route::controller(ClientsController::class)->group(function(){
                Route::get('clients', 'index')->name('clients.index');
                Route::post('clients', 'store')->name('clients.store');
                Route::post('showClients', 'show')->name('clients.show');
                Route::post('clients/{id}', 'update')->name('clients.update');
                Route::delete('clients/{id}', 'destroy')->name('clients.destroy');

                Route::get('getClientInvoices', 'getClientInvoices')->name('getClientInvoices');
            });

            //Clients Contacts
            Route::controller(ClientContactsController::class)->group(function(){
                Route::get('clientContacts', 'index')->name('clientContacts.index');
                Route::post('clientContacts', 'store')->name('clientContacts.store');
                Route::post('showClientContacts', 'show')->name('clientContacts.show');
                Route::delete('clientContacts/{id}', 'destroy')->name('clientContacts.destroy');
            });

            //Drivers
            Route::controller(DriversController::class)->group(function(){
                Route::get('drivers', 'allDrivers')->name('drivers.index');
                Route::post('showDrivers', 'show')->name('drivers.show');
                Route::post('drivers/{id}', 'update')->name('drivers.update');
                Route::delete('drivers/{id}', 'destroy')->name('drivers.destroy');
            });

            Route::controller(DriverJobsDocumentsController::class)->group(function(){
                Route::get('AllJobDocument', 'AllJobDocument')->name('AllJobDocument');
            });

            //Client Document
            Route::controller(ClientDocumentsController::class)->group(function(){
                Route::get('clientDocument', 'index')->name('clientDocument.index');
                Route::post('clientDocument', 'store')->name('clientDocument.store');
                Route::post('showClientDocument', 'show')->name('clientDocument.show');
                Route::post('clientDocument/{id}', 'update')->name('clientDocument.update');
                Route::delete('clientDocument/{id}', 'destroy')->name('clientDocument.destroy');
            });

            //Invoices
            Route::controller(InvoiceController::class)->group(function(){
                Route::get('invoices', 'index')->name('invoices.index');
                Route::post('invoices', 'store')->name('invoices.store');
                Route::post('showInvoices', 'show')->name('invoices.show');
                Route::post('sendInvoiceEmail', 'sendInvoiceEmail')->name('invoices.sendInvoiceEmail');
                Route::post('invoices/{id}', 'update')->name('invoices.update');
                Route::delete('invoices/{id}', 'destroy')->name('invoices.destroy');
            });

            //AllocatedInvoices
            Route::controller(AllocatedInvoicesController::class)->group(function(){
                Route::get('allocatedInvoices', 'index')->name('allocatedInvoices.index');
                Route::post('allocatedInvoices', 'store')->name('allocatedInvoices.store');
                Route::delete('allocatedInvoices/{id}', 'destroy')->name('allocatedInvoices.destroy');
            });

            //Quotes
            Route::controller(QuotesController::class)->group(function(){
                Route::get('quotes', 'index')->name('quotes.index');
                Route::post('quotes', 'store')->name('quotes.store');
                Route::post('showQuotes', 'show')->name('quotes.show');
                Route::post('sendQuoteEmail', 'sendQuoteEmail')->name('quotes.sendQuoteEmail');
                Route::post('quotes/{id}', 'update')->name('quotes.update');
                Route::delete('quotes/{id}', 'destroy')->name('quotes.destroy');
                //sales persons
                Route::get('salesPersons', 'salesPersons')->name('quotes.salesPersons');

                Route::post('acceptQuoteJob', 'acceptQuoteJob')->name('quotes.acceptQuoteJob');
            });

            //Quotes Terms & CConditions
            Route::controller(QuotesTermsConditionsController::class)->group(function(){
                Route::get('termsConditions', 'index')->name('termsConditions.index');
                Route::post('termsConditions', 'store')->name('termsConditions.store');
                Route::post('showTermsConditions', 'show')->name('termsConditions.show');
                Route::post('termsConditions/{id}', 'update')->name('termsConditions.update');
                Route::delete('termsConditions/{id}', 'destroy')->name('termsConditions.destroy');
            });

            //Quotes Footer
            Route::controller(QuotesFooterController::class)->group(function(){
                Route::get('quoteFooter', 'index')->name('quoteFooter.index');
                Route::post('quoteFooter', 'store')->name('quoteFooter.store');
                Route::post('showQuoteFooter', 'show')->name('quoteFooter.show');
                Route::post('quoteFooter/{id}', 'update')->name('quoteFooter.update');
                Route::delete('quoteFooter/{id}', 'destroy')->name('quoteFooter.destroy');
            });

            //QuoteDocuments
            Route::controller(QuoteDocumentsController::class)->group(function(){
                Route::get('quoteDocument', 'index')->name('quoteDocument.index');
                Route::post('quoteDocument', 'store')->name('quoteDocument.store');
                Route::post('showQuoteDocument', 'show')->name('quoteDocument.show');
                Route::post('quoteDocument/{id}', 'update')->name('quoteDocument.update');
                Route::delete('quoteDocument/{id}', 'destroy')->name('quoteDocument.destroy');
            });

            //Quote Settings
            Route::controller(QuotesSettingsController::class)->group(function(){
                Route::get('quoteSettings', 'index')->name('quoteSettings.index');
                Route::post('quoteSettings', 'store')->name('quoteSettings.store');
                Route::post('showQuoteSettings', 'show')->name('quoteSettings.show');
            });

            //Jobs
            Route::controller(JobsController::class)->group(function(){

                Route::get('getAllJobs', 'getAllJobs')->name('jobs.getAllJobs');

                Route::get('jobs', 'index')->name('jobs.index');
                Route::post('jobs', 'store')->name('jobs.store');
                Route::post('showJob', 'show')->name('jobs.show');
                Route::post('jobs/{id}', 'update')->name('jobs.update');
                Route::delete('jobs/{id}', 'destroy')->name('jobs.destroy');

                Route::get('fieldworkers/{jobId}', 'fieldworkers')->name('jobs.fieldworkers');
                Route::get('jobAssets/{jobId}', 'jobAssets')->name('jobs.jobAssets');
                Route::post('fieldworkers', 'assignFieldworker')->name('jobs.assignFieldWorker');
                Route::post('removeAssignFieldworker', 'removeAssignFieldworker')->name('jobs.removeAssignFieldworker');

                Route::get('timesheets', 'allTimesheets')->name('jobs.allTimesheets');
                Route::get('timesheets/{jobId}', 'timesheets')->name('jobs.timesheets');
                Route::post('timesheets', 'addTimesheet')->name('jobs.addTimesheet');
                Route::delete('timesheets', 'deleteTimesheet')->name('jobs.deleteTimesheet');

                Route::post('createMultiInvoices', 'createMultiInvoices')->name('jobs.createMultiInvoices');
                Route::post('addExistingMultiInvoices', 'addExistingMultiInvoices')->name('jobs.addExistingMultiInvoices');
                Route::post('changeTimeSheetStatus/{id}', 'changeTimeSheetStatus')->name('jobs.changeTimeSheetStatus');

                Route::get('getDriverAllocatedJobs/{driverId}', 'getDriverAllocatedJobsForAdmin')->name('getDriverAllocatedJobs');

                Route::get('getAllInvoices/{id}', 'getAllDraftInvoices')->name('getAllInvoices');

                Route::post('changeJobDate', 'updateJobDate')->name('changeJobDate');
            });

            //JobDocuments
            Route::controller(JobsDocumentsController::class)->group(function(){
                Route::get('jobDocument', 'index')->name('jobDocument.index');
                Route::post('jobDocument', 'store')->name('jobDocument.store');
                Route::post('showJobDocument', 'show')->name('jobDocument.show');
                Route::post('jobDocument/{id}', 'update')->name('jobDocument.update');
                Route::delete('jobDocument/{id}', 'destroy')->name('jobDocument.destroy');
            });

            //JobChecklist
            Route::controller(JobChecklistController::class)->group(function(){
                Route::get('checklist', 'index')->name('checklist.index');
                Route::post('checklist', 'store')->name('checklist.store');
                Route::post('showChecklist', 'show')->name('checklist.show');
                Route::post('checklist/{id}', 'update')->name('checklist.update');
                Route::delete('checklist/{id}', 'destroy')->name('checklist.destroy');

                Route::post('driver-checklist', 'driverChecklists')->name('driver-checklist');
                Route::post('driverChecklist', 'driverChecklistDetail')->name('driverChecklist');
                Route::post('singleChecklist', 'driverSingleChecklist')->name('driverSingleChecklist');

                Route::post('complete-checklist', 'driverChecklist')->name('complete-checklist');
                Route::post('complete-checklist/save', 'saveDriverChecklist')->name('complete-checklist-save');
            });

            //Templates
            Route::controller(EmailSettingsController::class)->group(function(){
                Route::get('emailSettings', 'index')->name('emailSettings.index');
                Route::post('emailSettings', 'store')->name('emailSettings.store');
                Route::get('quoteEmailTemplate', 'quoteEmailTemplate')->name('quoteEmailTemplate.index');
                Route::post('quoteEmailTemplate', 'quoteEmailTemplateSave')->name('quoteEmailTemplate.store');
            });

            //Quotes Docusign
            Route::controller(DocuSignController::class)->group(function(){
                Route::post('uploadFileForSign', 'uploadFileForSign')->name('uploadFileForSign');
            });
        });

        //Accounts
        Route::group(['middleware' => 'is_admin:accounts', 'prefix' => 'accounts', 'as' => 'accounts.'], function () {

            //Change Password
            Route::controller(UserController::class)->group(function() {
                Route::post('changePassword', 'change_password')->name('changePassword');;
            });

            // Users Module
            Route::controller(UserController::class)->group(function(){
                //Users Modules
                Route::get('users', 'index')->name('users.index');
                Route::post('users', 'store')->name('users.store');
                Route::get('users/create', 'create')->name('users.create');
                Route::post('userShow', 'show')->name('users.show');
                Route::post('users/{id}', 'update')->name('users.update');
                Route::delete('users/{id}', 'destroy')->name('users.destroy');
                Route::post('changeStatus/{id}', 'changeStatus')->name('users.status');
                //User Roles
                Route::get('userRoles', 'userRoles')->name('users.userRoles');
                //All Logs and Activities
                Route::get('allLogs', 'allLogs')->name('users.allLogs');
                Route::get('allActivities/{id}', 'allActivities')->name('users.allActivities');
            });

            //User tags
            Route::controller(UserTagsController::class)->group(function(){
                Route::get('userTags', 'index')->name('userTags.index');
                Route::post('userTags', 'store')->name('userTags.store');
                Route::delete('userTags/{id}', 'destroy')->name('userTags.destroy');
            });

            // User Addresses
            Route::controller(AddressesController::class)->group(function(){
                Route::get('addresses', 'index')->name('addresses.index');
                Route::post('addresses', 'store')->name('addresses.store');
                Route::post('showAddress', 'show')->name('addresses.show');
                Route::post('addresses/{id}', 'update')->name('addresses.update');
                Route::delete('addresses/{id}', 'destroy')->name('addresses.destroy');
            });

            //Roles
            Route::controller(RolesController::class)->group(function(){
                Route::get('roles', 'index')->name('roles.index');
                Route::post('roles', 'store')->name('roles.store');
                Route::post('showRoles', 'show')->name('roles.show');
                Route::post('roles/{id}', 'update')->name('roles.update');
                Route::delete('roles/{id}', 'destroy')->name('roles.destroy');
            });

            //Permissions
            Route::controller(PermissionsController::class)->group(function(){
                Route::get('permissions', 'index')->name('permissions.index');
                Route::post('permissions', 'store')->name('permissions.store');
                Route::post('showPermissions', 'edit')->name('permissions.edit');
                Route::post('permissions/{id}', 'update')->name('permissions.update');
                Route::delete('permissions/{id}', 'destroy')->name('permissions.destroy');
            });

            //Notes
            Route::controller(NotessController::class)->group(function(){
                Route::get('notes', 'index')->name('notes.index');
                Route::post('notes', 'store')->name('notes.store');
                Route::post('showNotes', 'show')->name('notes.show');
                Route::delete('notes/{id}', 'destroy')->name('notes.destroy');
            });

            //Documents
            Route::controller(DocumentsController::class)->group(function(){
                Route::get('documents', 'index')->name('documents.index');
                Route::post('documents', 'store')->name('documents.store');
                Route::post('showDocuments', 'show')->name('documents.show');
                Route::delete('documents/{id}', 'destroy')->name('documents.destroy');
            });

            //Account Quotes
            Route::controller(ClientQuotesController::class)->group(function(){
                Route::get('client-quotes', 'index')->name('client-quotes.index');
                Route::post('client-quotes', 'store')->name('client-quotes.store');
                Route::post('showClientQuotes', 'show')->name('client-quotes.show');
                Route::post('approveQuote', 'approveQuote')->name('client-quotes.approveQuote');
            });

            //Drivers
            Route::controller(DriversController::class)->group(function(){
                Route::get('drivers', 'allDrivers')->name('drivers.index');
                Route::post('showDrivers', 'show')->name('drivers.show');
                Route::post('drivers/{id}', 'update')->name('drivers.update');
                Route::delete('drivers/{id}', 'destroy')->name('drivers.destroy');
            });

            //Jobs
            Route::controller(JobsController::class)->group(function(){
                Route::get('jobs', 'index')->name('jobs.index');
                Route::post('jobs', 'store')->name('jobs.store');
                Route::post('showJob', 'show')->name('jobs.show');
                Route::post('jobs/{id}', 'update')->name('jobs.update');
                Route::delete('jobs/{id}', 'destroy')->name('jobs.destroy');

                Route::get('fieldworkers/{jobId}', 'fieldworkers')->name('jobs.fieldworkers');
                Route::get('jobAssets/{jobId}', 'jobAssets')->name('jobs.jobAssets');
                Route::post('fieldworkers', 'assignFieldworker')->name('jobs.assignFieldWorker');
                Route::post('removeAssignFieldworker', 'removeAssignFieldworker')->name('jobs.removeAssignFieldworker');

                Route::get('timesheets', 'allTimesheets')->name('jobs.allTimesheets');
                Route::get('timesheets/{jobId}', 'timesheets')->name('jobs.timesheets');
                Route::post('timesheets', 'addTimesheet')->name('jobs.addTimesheet');
                Route::delete('timesheets', 'deleteTimesheet')->name('jobs.deleteTimesheet');

                Route::post('createMultiInvoices', 'createMultiInvoices')->name('jobs.createMultiInvoices');
                Route::post('changeTimeSheetStatus/{id}', 'changeTimeSheetStatus')->name('jobs.changeTimeSheetStatus');

                Route::get('getDriverAllocatedJobs/{driverId}', 'getDriverAllocatedJobsForAdmin')->name('getDriverAllocatedJobs');
                Route::get('getAllInvoices/{id}', 'getAllDraftInvoices')->name('getAllInvoices');
            });

            Route::controller(DriverJobsDocumentsController::class)->group(function(){
                Route::get('AllJobDocument', 'AllJobDocument')->name('AllJobDocument');
            });

            //JobChecklist
            Route::controller(JobChecklistController::class)->group(function(){
                Route::get('checklist', 'index')->name('checklist.index');
                Route::post('checklist', 'store')->name('checklist.store');
                Route::post('showChecklist', 'show')->name('checklist.show');
                Route::post('checklist/{id}', 'update')->name('checklist.update');
                Route::delete('checklist/{id}', 'destroy')->name('checklist.destroy');

                Route::post('driver-checklist', 'driverChecklists')->name('driver-checklist');
                Route::post('driverChecklist', 'driverChecklistDetail')->name('driverChecklist');
                Route::post('singleChecklist', 'driverSingleChecklist')->name('driverSingleChecklist');
            });
        });

        //Allocators
        Route::group(['middleware' => 'is_admin:allocators', 'prefix' => 'allocators', 'as' => 'allocators.'], function () {

            //Change Password
            Route::controller(UserController::class)->group(function() {
                Route::post('changePassword', 'change_password')->name('changePassword');;
            });

            //getDashboardDataAssets
            Route::get('getDashboardDataAssets', [DashboardController::class, 'getDashboardDataAssets'])->name('getDashboardDataAssets');
            //getDashboardAssetsInUse
            Route::get('getDashboardAssetsInUse', [DashboardController::class, 'getDashboardAssetsInUse'])->name('getDashboardAssetsInUse');

            //Attachments
            Route::controller(AttachmentsController::class)->group(function(){
                Route::get('attachments', 'index')->name('attachments.index');
                Route::post('attachments', 'store')->name('attachments.store');
                Route::post('showAttachments', 'show')->name('attachments.show');
                Route::post('attachments/{id}', 'update')->name('attachments.update');
                Route::delete('attachments/{id}', 'destroy')->name('attachments.destroy');
            });

            //Attachment Documents
            Route::controller(AttachmentDocumentsController::class)->group(function(){
                Route::get('attachmentDocuments', 'index')->name('attachmentDocuments.index');
                Route::post('attachmentDocuments', 'store')->name('attachmentDocuments.store');
                Route::post('showAttachmentDocuments', 'show')->name('attachmentDocuments.show');
                Route::delete('attachmentDocuments/{id}', 'destroy')->name('attachmentDocuments.destroy');
            });

            //Tags
            Route::controller(TagsController::class)->group(function(){
                Route::get('tags', 'index')->name('tags.index');
                Route::post('tags', 'store')->name('tags.store');
                Route::delete('tags/{id}', 'destroy')->name('tags.destroy');
            });

            //Skills
            Route::controller(SkillsController::class)->group(function(){
                Route::get('skills', 'index')->name('skills.index');
                Route::post('skills', 'store')->name('skills.store');
                Route::delete('skills/{id}', 'destroy')->name('skills.destroy');
            });

            //Resource Category
            Route::controller(ResourceTagCategoriesController::class)->group(function(){
                Route::get('resourceCategory', 'index')->name('resourceCategory.index');
                Route::post('resourceCategory', 'store')->name('resourceCategory.store');
                Route::delete('resourceCategory/{id}', 'destroy')->name('resourceCategory.destroy');
            });

            //Assets
            Route::controller(AssetController::class)->group(function(){
                Route::get('assets', 'index')->name('assets.index');
                Route::post('assets', 'store')->name('assets.store');
                Route::post('showAsset', 'show')->name('assets.show');
                Route::post('assets/{id}', 'update')->name('assets.update');
                Route::delete('assets/{id}', 'destroy')->name('assets.destroy');
            });

            //Asset Documents
            Route::controller(AssetDocumentsController::class)->group(function(){
                Route::get('assetDocuments', 'index')->name('assetDocuments.index');
                Route::post('assetDocuments', 'store')->name('assetDocuments.store');
                Route::post('showAssetDocuments', 'show')->name('assetDocuments.show');
                Route::delete('assetDocuments/{id}', 'destroy')->name('assetDocuments.destroy');
            });

            //Asset Subcontractor
            Route::controller(AssetSubcontractorController::class)->group(function(){
                Route::get('assetSubcontractor', 'index')->name('assetSubcontractor.index');
                Route::post('assetSubcontractor', 'store')->name('assetSubcontractor.store');
                Route::post('showAssetSubcontractor', 'show')->name('assetSubcontractor.show');
                Route::post('assetSubcontractor/{id}', 'update')->name('assetSubcontractor.update');
                Route::delete('assetSubcontractor/{id}', 'destroy')->name('assetSubcontractor.destroy');
            });

            // Users Module
            Route::controller(UserController::class)->group(function(){
                //Users Modules
                Route::get('users', 'index')->name('users.index');
            });

            //Subcontractor
            Route::controller(SubcontractorController::class)->group(function(){
                Route::get('subcontractors', 'index')->name('subcontractors.index');
            });

            //Drivers Module
            Route::controller(DriversController::class)->group(function() {
                Route::get('drivers', 'index')->name('drivers.index');
                Route::get('allDrivers', 'allDrivers')->name('drivers.allDrivers');
            });

            //Jobs
            Route::controller(JobsController::class)->group(function(){
                Route::get('jobs', 'index')->name('jobs.index');
                Route::post('jobs', 'store')->name('jobs.store');
                Route::post('showJob', 'show')->name('jobs.show');
                Route::post('jobs/{id}', 'update')->name('jobs.update');
                Route::delete('jobs/{id}', 'destroy')->name('jobs.destroy');

                Route::get('fieldworkers/{jobId}', 'fieldworkers')->name('jobs.fieldworkers');
                Route::get('jobAssets/{jobId}', 'jobAssets')->name('jobs.jobAssets');
                Route::post('fieldworkers', 'assignFieldworker')->name('jobs.assignFieldWorker');
                Route::post('removeAssignFieldworker', 'removeAssignFieldworker')->name('jobs.removeAssignFieldworker');

                Route::get('timesheets/{jobId}', 'timesheets')->name('jobs.timesheets');
                Route::post('timesheets', 'addTimesheet')->name('jobs.addTimesheet');
                Route::delete('timesheets', 'deleteTimesheet')->name('jobs.deleteTimesheet');
            });

            //JobDocuments
            Route::controller(JobsDocumentsController::class)->group(function(){
                Route::get('jobDocument', 'index')->name('jobDocument.index');
                Route::post('jobDocument', 'store')->name('jobDocument.store');
                Route::post('showJobDocument', 'show')->name('jobDocument.show');
                Route::post('jobDocument/{id}', 'update')->name('jobDocument.update');
                Route::delete('jobDocument/{id}', 'destroy')->name('jobDocument.destroy');
            });

            //Clients
            Route::controller(ClientsController::class)->group(function(){
                Route::get('clients', 'index')->name('clients.index');
            });

            //Job Checklist
            Route::controller(JobChecklistController::class)->group(function(){
                Route::get('checklist', 'index')->name('checklist.index');
            });
        });

        //Sales
        Route::group(['middleware' => 'is_admin:sales', 'prefix' => 'sales', 'as' => 'sales.'], function () {
            //Change Password
            Route::controller(UserController::class)->group(function() {
                Route::post('changePassword', 'change_password')->name('changePassword');;
            });
        });

        //Drivers
        Route::group(['middleware' => 'is_admin:drivers', 'prefix' => 'drivers', 'as' => 'drivers.'], function () {
            //Driver Dashboard Jobs
            Route::get('getDriverAllocatedJobs', [JobsController::class, 'getDriverAllocatedJobs'])->name('getDriverAllocatedJobs');
            //Change Password
            Route::controller(UserController::class)->group(function() {
                Route::post('changePassword', 'change_password')->name('changePassword');;
            });
            //Jobs
            Route::controller(DriverJobsController::class)->group(function(){
                Route::get('jobs', 'index')->name('jobs.index');
                Route::post('jobs', 'store')->name('jobs.store');
                Route::post('showJob', 'show')->name('jobs.show');
                Route::post('jobs/{id}', 'update')->name('jobs.update');
                Route::delete('jobs/{id}', 'destroy')->name('jobs.destroy');

                Route::get('fieldworkers/{jobId}', 'fieldworkers')->name('jobs.fieldworkers');
                Route::get('jobAssets/{jobId}', 'jobAssets')->name('jobs.jobAssets');
                Route::post('assignFieldworker', 'assignFieldworker')->name('jobs.assignFieldWorker');
                Route::delete('removeAssignFieldworker', 'removeAssignFieldworker')->name('jobs.removeAssignFieldworker');

                Route::get('timesheets/{jobId}', 'timesheets')->name('jobs.timesheets');
                Route::post('timesheets', 'addTimesheet')->name('jobs.addTimesheet');
                Route::delete('timesheets', 'deleteTimesheet')->name('jobs.deleteTimesheet');
            });

            //Assets
            Route::controller(AssetController::class)->group(function(){
                Route::get('assets', 'index')->name('assets.index');
                Route::post('showAsset', 'show')->name('assets.show');
            });

            //Clients
            Route::controller(ClientsController::class)->group(function(){
                Route::get('clients', 'index')->name('clients.index');
            });

            //Job Checklist
            Route::controller(JobChecklistController::class)->group(function(){
                Route::post('complete-checklist', 'driverChecklist')->name('complete-checklist');
                Route::post('complete-checklist/save', 'saveDriverChecklist')->name('complete-checklist-save');
            });

            //Driver Jobs Documents
            Route::controller(DriverJobsDocumentsController::class)->group(function(){
                Route::get('jobDocument', 'index')->name('jobDocument.index');
                Route::post('jobDocument', 'store')->name('jobDocument.store');
                Route::post('showJobDocument', 'show')->name('jobDocument.show');
                Route::delete('jobDocument/{id}', 'destroy')->name('jobDocument.destroy');
            });
        });

        //Safety Officer
        Route::group(['middleware' => 'is_admin:safetyOfficer', 'prefix' => 'safetyOfficer', 'as' => 'safetyOfficer.'], function () {

            //Safety Officer Dashboard
            Route::get('getSafetyOfficerDash', [DashboardController::class, 'getSafetyOfficerDash'])->name('getSafetyOfficerDash');

            //Change Password
            Route::controller(UserController::class)->group(function() {
                Route::post('changePassword', 'change_password')->name('changePassword');;
            });

            //JobChecklist
            Route::controller(JobChecklistController::class)->group(function(){
                Route::get('checklist', 'index')->name('checklist.index');
                Route::post('checklist', 'store')->name('checklist.store');
                Route::post('showChecklist', 'show')->name('checklist.show');
                Route::post('checklist/{id}', 'update')->name('checklist.update');
                Route::delete('checklist/{id}', 'destroy')->name('checklist.destroy');

                Route::post('driver-checklist', 'driverChecklists')->name('driver-checklist');
                Route::post('driverChecklist', 'driverChecklistDetail')->name('driverChecklist');
                Route::post('singleChecklist', 'driverSingleChecklist')->name('driverSingleChecklist');
            });

            //Jobs
            Route::controller(JobsController::class)->group(function(){
                Route::get('jobs', 'index')->name('jobs.index');
                Route::post('showJob', 'show')->name('jobs.show');
                Route::post('jobs/{id}', 'update')->name('jobs.update');

                Route::get('getDriverAllocatedJobs/{driverId}', 'getDriverAllocatedJobsForAdmin')->name('getDriverAllocatedJobs');
            });

            //Drivers
            Route::controller(DriversController::class)->group(function(){
                Route::get('drivers', 'allDrivers')->name('drivers.index');
                Route::post('showDrivers', 'show')->name('drivers.show');
                Route::post('drivers/{id}', 'update')->name('drivers.update');
                Route::delete('drivers/{id}', 'destroy')->name('drivers.destroy');
                Route::get('allDrivers', 'allDrivers')->name('drivers.allDrivers');
            });
            Route::controller(DriverJobsDocumentsController::class)->group(function(){
                Route::get('AllJobDocument', 'AllJobDocument')->name('AllJobDocument');
            });
        });

        //Logout
        Route::get('logout', [AuthController::class,'logout'])->name('logout');
    });
});
