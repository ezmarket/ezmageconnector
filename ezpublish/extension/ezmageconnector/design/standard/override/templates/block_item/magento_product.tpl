{def $product = $node.data_map.product.content}
<article class="selected-products">
    <div class="attribute-image">
        <a href="{$node.url_alias|ezurl('no')}" title="{$node.name|wash()}">
            <img src="{$product.images[0]['url']}" alt="{$product.images[0]['label']|wash()}" />
        </a>
    </div>
    <div class="product-info">
        <div class="attribute-header">
            <a href="{$node.url_alias|ezurl( 'no' )}" class="teaser-link">
                <h3>{$node.name|wash()}</h3>
            </a>
        </div>
        <ul class="breadcrumb">
            {foreach $node.path as $path_item}
            <li>
                <a href="{$path_item.url_alias|ezurl( 'no' )}">{$path_item.name|wash()}</a>
                {delimiter}
                <span class="divider">»</span>
                {/delimiter}
            </li>
            {/foreach}
        </ul>
        <form method="post" action={"content/action"|ezurl}>
            <fieldset>
                <div class="item-price">
                    {$product.price|l10n( 'currency' )}
                </div>
                <div class="item-buying-action form-inline">
                    <label>
                        <span class="hidden">{'Amount'|i18n("design/ezdemo/block_item/product")}</span>
                        <input type="text" name="Quantity" />
                    </label>
                    <button class="btn btn-warning" type="submit" name="ActionAddToBasket">
                        {'Buy'|i18n("design/ezdemo/block_item/product")}
                    </button>
                </div>
            </fieldset>
            <input type="hidden" name="ContentNodeID" value="{$node.node_id}" />
            <input type="hidden" name="ContentObjectID" value="{$node.object.id}" />
            <input type="hidden" name="ViewMode" value="full" />
        </form>
    </div>
</article>
{undef $product}
