<div class="se-pre-con"></div>

<div class="crm-submit-buttons">
{include file="CRM/common/formButtons.tpl" location="top"}
</div>

<div class="crm-copy-fields crm-grid-table" id="crm-batch-entry-table">
  <div class="crm-grid-header">
    <div class="crm-grid-cell">&nbsp;</div>
    <div class="crm-grid-cell">{$form.user_group.1.label}</div>
    <div class="crm-grid-cell">{$form.from_address.1.label}</div>
    <div class="crm-grid-cell">{$form.to_groups.1.label}</div>
  </div>

  {section name='i' start=1 loop=$rowCount}
    {assign var='rowNumber' value=$smarty.section.i.index}
    <div class="{cycle values="odd-row,even-row"} selector-rows crm-grid-row" entity_id="{$rowNumber}">
      <div class="compressed crm-grid-cell">{$rowNumber}</div>
      <div class="compressed crm-grid-cell">{$form.user_group.$rowNumber.html}</div>
      <div class="compressed crm-grid-cell">{$form.from_address.$rowNumber.html}</div>
      <div class="compressed crm-grid-cell">{$form.to_groups.$rowNumber.html}</div>
    </div>
  {/section}
</div>

<div class="crm-submit-buttons">
{include file="CRM/common/formButtons.tpl" location="bottom"}
</div>
