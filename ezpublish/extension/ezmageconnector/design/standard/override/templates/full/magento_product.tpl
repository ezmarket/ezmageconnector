{* Product - Full view *}

{set scope=global persistent_variable=hash('left_menu', false(),
                                           'extra_menu', false())}

{def $product = $node.data_map.product.content}

<section class="content-view-full">
    <article class="class-product row">
        <div class="span8">
            {if $product['images']}
                <div class="attribute-image full-head">
                    <img src="{$product['images'][0]['url']}" alt="{$product['images'][0]['label']|wash()}" />

                    {if $product['images'][0]['label']}
                        <div class="attribute-caption">
                            {$product['images'][0]['label']|wash()}
                        </div>
                    {/if}
                </div>
            {/if}

            <div class="attribute-short">
               {$product['short_description']}
            </div>

            <div class="attribute-long">
               {$product['description']}
            </div>

            {* Category. *}
            {def $product_category_attribute=ezini( 'VATSettings', 'ProductCategoryAttribute', 'shop.ini' )}
            {if and( $product_category_attribute, is_set( $node.data_map.$product_category_attribute ) )}
            <div class="attribute-long">
              <p>Category:&nbsp;{attribute_view_gui attribute=$node.data_map.$product_category_attribute}</p>
            </div>
            {/if}
            {undef $product_category_attribute}

           {* Related products. *}
           {def $related_purchase=fetch( 'shop', 'related_purchase', hash( 'contentobject_id', $node.object.id, 'limit', 10 ) )}
           {if $related_purchase}
            <div class="relatedorders">
                <h2>{'People who bought this also bought'|i18n( 'design/ezdemo/full/product' )}</h2>

                <ul>
                {foreach $related_purchase as $product}
                    <li>{content_view_gui view=text_linked content_object=$product}</li>
                {/foreach}
                </ul>
            </div>
           {/if}
           {undef $related_purchase}
        </div>
        <div class="span4">
            <aside>
                <section class="content-view-aside">
                    <div class="product-main">
                        <div class="attribute-header">
                            <h2>{$node.name|wash()}</h2>
                            <span class="subheadline">{$product['sku']}</span>
                        </div>
                        <article>
                            <form method="post" action={"content/action"|ezurl}>
                                <fieldset class="row">
                                    <div class="item-price span4">
                                    {if $product['special_price']}
                                        {$product['special_price']|l10n( 'currency' )} <span class="old-price">{$product['price']|l10n( 'currency' )}</span>
                                    {else}
                                        {$product['price']|l10n( 'currency' )}
                                    {/if}
                                    </div>
                                    <div class="span4">

                                    </div>
                                    <div class="item-buying-action form-inline span4">
                                        <label>
                                            <span class="hidden">{'Amount'|i18n("design/ezdemo/full/product")}</span>
                                            <input type="text" name="Quantity" />
                                        </label>
                                        <button class="btn btn-warning" type="submit" name="ActionAddToBasket">
                                        {'Add to basket'|i18n("design/ezdemo/full/product")}
                                        </button>
                                    </div>
                                </fieldset>
                                <input type="hidden" name="ContentNodeID" value="{$node.node_id}" />
                                <input type="hidden" name="ContentObjectID" value="{$node.object.id}" />
                                <input type="hidden" name="ViewMode" value="full" />
                            </form>
                        </article>
                        <div class="attribute-socialize">
                            {include uri='design:parts/social_buttons.tpl'}
                        </div>
                    </div>
                </section>
            </aside>
        </div>
   </article>
</section>

{undef $product}
