<?php require('viewHeader.php'); ?>

<div class="banner container">
    <h1>Fundamentals</h1>
    <div>
        These are algorithms that every programmer should know.
        Whether you're an beginner or expert. No Excuses.
    </div>
</div>
<div class="container">
    <main>
        <h2>{{category name}}</h2>
        <hr/>
        <article>
            <h3>{{alg name}}</h3>
            <details>
                <summary>Overview</summary>
                <table>
                    <tbody>
                    <tr>
                        <td><strong>Run Time:</strong> n<sup></sup></td>
                        <td><strong>Complexity:</strong> Simple - Recursion</td>
                    </tr>
                    <tr>
                        <td><strong>Implementation:</strong> Short</td>
                        <td><strong>Data Structures:</strong> None</td>
                    </tr>
                    </tbody>
                </table>
            </details>
            <section class="description">
                Compute the greatest common divisor of
                two non-negative integers p and q as follows:
                If q is 0, the answer is p. If not, divide p by q
                and take the remainder r. The answer is the
                greatest common divisor of q and r.
            </section>

<pre class="prettyprint linenums">
public static int gcd(int p, int q)
{
if (q == 0) return p;
int r = p % q;
return gcd(q, r);
}
</pre>
        </article>

    </main>

</div>
<?php require('viewFooter.php'); ?>